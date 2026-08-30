<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\LocalHelper;
use App\Models\Auditoria;

class PagoController extends Controller
{
    /**
     * LISTAR PAGOS DE UNA VENTA
     */
    public function index(Request $request, Venta $venta)
    {
        if ($venta->local_id != LocalHelper::id()) {
            abort(404);
        }
        $pagos = $venta->pagos()
            ->orderBy('fecha', 'desc')
            ->get();

        $venta->load('pagos');

        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
                'data' => [
                    'venta' => $venta,
                    'pagos' => $pagos,
                ]
            ]);
        }

        return view(
            'pagos.index',
            compact(
                'venta',
                'pagos'
            )
        );
    }


    /**
     * FORMULARIO PARA REGISTRAR PAGO
     */
    public function create(Venta $venta)
    {
        if ($venta->local_id != LocalHelper::id()) {
            abort(404);
        }
        if ($venta->estado === 'ANULADA') {

            return redirect()
                ->route('ventas.show', $venta)
                ->withErrors([
                    'pago' =>
                    'No se pueden registrar pagos de una venta anulada.'
                ]);
        }

        if ($venta->saldo_pendiente <= 0) {

            return redirect()
                ->route('ventas.show', $venta)
                ->with(
                    'success',
                    'Esta venta ya está completamente pagada.'
                );
        }

        return view(
            'pagos.create',
            compact('venta')
        );
    }


    /**
     * REGISTRAR PAGO
     */
    public function store(Request $request, Venta $venta)
    {
        $validated = $request->validate([

            'fecha' => [
                'nullable',
                'date'
            ],

            'monto' => [
                'required',
                'numeric',
                'gt:0'
            ],

            'medio_pago' => [
                'required',
                'in:EFECTIVO,DEPOSITO,TRANSFERENCIA,OTRO'
            ],

            'medio_pago_otro' => [
                'nullable',
                'string',
                'max:100'
            ],

            'observacion' => [
                'nullable',
                'string'
            ],

        ], [

            'monto.required' =>
            'El monto del pago es obligatorio.',

            'monto.numeric' =>
            'El monto debe ser numérico.',

            'monto.gt' =>
            'El monto debe ser mayor que cero.',

            'medio_pago.required' =>
            'Debe seleccionar un medio de pago.',
        ]);


        try {

            if ($venta->local_id != LocalHelper::id()) {
                abort(404);
            }
            $resultado = DB::transaction(function () use (
                $validated,
                $venta
            ) {

                /*
                |--------------------------------------------------------------------------
                | BLOQUEAR LA VENTA
                |--------------------------------------------------------------------------
                */

                $venta = Venta::where('id', $venta->id)
                    ->where('local_id', LocalHelper::id())
                    ->lockForUpdate()
                    ->firstOrFail();


                /*
                |--------------------------------------------------------------------------
                | VALIDAR ESTADO
                |--------------------------------------------------------------------------
                */

                if ($venta->estado === 'ANULADA') {

                    throw new \Exception(
                        'No se puede registrar un pago de una venta anulada.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | CALCULAR SALDO ACTUAL
                |--------------------------------------------------------------------------
                */

                $saldoActual =
                    (float) $venta->saldo_pendiente;


                if ($saldoActual <= 0) {

                    throw new \Exception(
                        'La venta ya está completamente pagada.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | VALIDAR QUE EL PAGO NO SUPERE EL SALDO
                |--------------------------------------------------------------------------
                */

                $monto =
                    (float) $validated['monto'];


                if ($monto > $saldoActual) {

                    throw new \Exception(
                        'El monto del pago no puede ser mayor al saldo pendiente de S/ ' .
                            number_format(
                                $saldoActual,
                                2
                            )
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | REGISTRAR PAGO
                |--------------------------------------------------------------------------
                */

                $pago = Pago::create([

                    'venta_id' =>
                    $venta->id,

                    'user_id' => auth()->id(),

                    'fecha' =>
                    $validated['fecha'] ?? now(),

                    'monto' =>
                    $monto,

                    'medio_pago' =>
                    $validated['medio_pago'],

                    'medio_pago_otro' =>
                    $validated['medio_pago_otro'] ?? null,

                    'observacion' =>
                    $validated['observacion'] ?? null,
                ]);

                Auditoria::registrar(
                    'CREAR',
                    'pagos',
                    $pago->id,
                    'Registró un pago de S/ ' .
                        number_format($pago->monto, 2) .
                        ' para la venta #' .
                        $venta->id,
                    null,
                    $pago->toArray()
                );


                /*
                |--------------------------------------------------------------------------
                | NUEVOS VALORES
                |--------------------------------------------------------------------------
                */

                $nuevoMontoPagado =
                    (float) $venta->monto_pagado +
                    $monto;


                $nuevoSaldo =
                    (float) $venta->total -
                    $nuevoMontoPagado;


                /*
                |--------------------------------------------------------------------------
                | EVITAR ERRORES DE DECIMALES
                |--------------------------------------------------------------------------
                */

                if ($nuevoSaldo < 0.01) {

                    $nuevoSaldo = 0;
                }


                /*
                |--------------------------------------------------------------------------
                | DETERMINAR ESTADO
                |--------------------------------------------------------------------------
                */

                if ($nuevoSaldo == 0) {

                    $estadoPago = 'CANCELADO';
                } elseif ($nuevoMontoPagado > 0) {

                    $estadoPago = 'PARCIAL';
                } else {

                    $estadoPago = 'PENDIENTE';
                }


                /*
                |--------------------------------------------------------------------------
                | ACTUALIZAR VENTA
                |--------------------------------------------------------------------------
                */

                $venta->update([

                    'monto_pagado' =>
                    $nuevoMontoPagado,

                    'saldo_pendiente' =>
                    $nuevoSaldo,

                    'estado_pago' =>
                    $estadoPago,

                ]);


                return [
                    'venta' =>
                    $venta->fresh(),

                    'pago' =>
                    $pago,

                    'monto_pagado' =>
                    $nuevoMontoPagado,

                    'saldo_pendiente' =>
                    $nuevoSaldo,

                    'estado_pago' =>
                    $estadoPago,
                ];
            });


            /*
            |--------------------------------------------------------------------------
            | API
            |--------------------------------------------------------------------------
            */

            if ($request->expectsJson()) {

                return response()->json([

                    'success' => true,

                    'message' =>
                    'Pago registrado correctamente.',

                    'data' =>
                    $resultado

                ], 201);
            }


            /*
            |--------------------------------------------------------------------------
            | BLADE
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route(
                    'pagos.index',
                    $venta
                )
                ->with(
                    'success',
                    'Pago registrado correctamente.'
                );
        } catch (\Throwable $e) {

            if ($request->expectsJson()) {

                return response()->json([

                    'success' => false,

                    'message' =>
                    'No se pudo registrar el pago.',

                    'error' =>
                    $e->getMessage()

                ], 422);
            }


            return back()
                ->withInput()
                ->withErrors([
                    'pago' =>
                    $e->getMessage()
                ]);
        }
    }


    /**
     * MOSTRAR PAGO
     */
    public function show(Request $request, Pago $pago)
    {

        $pago->load('venta');
        if (!$pago->venta || $pago->venta->local_id != LocalHelper::id()) {
            abort(404);
        }

        if ($request->expectsJson()) {

            return response()->json([

                'success' => true,

                'data' => $pago

            ]);
        }

        return view(
            'pagos.show',
            compact('pago')
        );
    }
}
