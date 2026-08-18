<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $query = Venta::with([
            'detalles.producto'
        ])
            ->orderBy('fecha', 'desc');

        if ($request->filled('medio_pago')) {

            $query->where(
                'medio_pago',
                $request->medio_pago
            );
        }

        if ($request->filled('estado_pago')) {

            $query->where(
                'estado_pago',
                $request->estado_pago
            );
        }

        if ($request->filled('fecha_inicio')) {

            $query->whereDate(
                'fecha',
                '>=',
                $request->fecha_inicio
            );
        }

        if ($request->filled('fecha_fin')) {

            $query->whereDate(
                'fecha',
                '<=',
                $request->fecha_fin
            );
        }


        $ventas = $query
            ->paginate(20)
            ->withQueryString();

        if ($request->expectsJson()) {

            return response()->json([

                'success' => true,

                'data' => $ventas

            ]);
        }

        return view(
            'ventas.index',
            compact('ventas')
        );
    }
    public function store(Request $request)
    {
        $validated = $request->validate([

            'fecha' => 'nullable|date',

            'medio_pago' => [
                'required',
                'in:EFECTIVO,DEPOSITO,TRANSFERENCIA,OTRO'
            ],

            'medio_pago_otro' => [
                'nullable',
                'string',
                'max:100'
            ],

            'estado_pago' => [
                'required',
                'in:CANCELADO,PENDIENTE,PARCIAL,OTRO'
            ],

            'monto_pagado' => [
                'required',
                'numeric',
                'min:0'
            ],

            'observacion' => [
                'nullable',
                'string'
            ],

            'detalles' => [
                'required',
                'array',
                'min:1'
            ],

            'detalles.*.producto_id' => [
                'required',
                'exists:productos,id'
            ],

            'detalles.*.cantidad' => [
                'required',
                'numeric',
                'gt:0'
            ],

            'detalles.*.precio_unitario' => [
                'required',
                'numeric',
                'min:0'
            ],

        ]);

        $productoIds = collect($validated['detalles'])
            ->pluck('producto_id');

        if ($productoIds->duplicates()->isNotEmpty()) {

            return response()->json([
                'success' => false,
                'message' =>
                'No se puede repetir un producto dentro de la misma venta.'
            ], 422);
        }


        try {

            $venta = DB::transaction(function () use ($validated) {

                $total = 0;

                $productos = [];

                foreach ($validated['detalles'] as $detalle) {

                    $producto = Producto::where(
                        'id',
                        $detalle['producto_id']
                    )
                        ->lockForUpdate()
                        ->firstOrFail();



                    if (!$producto->estado) {

                        throw new \Exception(
                            "El producto {$producto->codigo} está inactivo."
                        );
                    }



                    $stock = $producto->stock_actual;


                    if ($detalle['cantidad'] > $stock) {

                        throw new \Exception(
                            "Stock insuficiente para " .
                                $producto->codigo .
                                ". Stock disponible: " .
                                number_format($stock, 3)
                        );
                    }


                    $precioTotal =
                        $detalle['cantidad'] *
                        $detalle['precio_unitario'];


                    $total += $precioTotal;


                    $productos[] = [

                        'producto' => $producto,

                        'cantidad' =>
                        $detalle['cantidad'],

                        'precio_unitario' =>
                        $detalle['precio_unitario'],

                        'precio_total' =>
                        $precioTotal,

                    ];
                }


                if ($validated['monto_pagado'] > $total) {

                    throw new \Exception(
                        'El monto pagado no puede ser mayor al total.'
                    );
                }


                $saldoPendiente =
                    $total -
                    $validated['monto_pagado'];


                $venta = Venta::create([

                    'estado' => 'ACTIVA',

                    'fecha' =>
                    $validated['fecha'] ?? now(),

                    'total' =>
                    $total,

                    'medio_pago' =>
                    $validated['medio_pago'],

                    'medio_pago_otro' =>
                    $validated['medio_pago_otro'] ?? null,

                    'estado_pago' =>
                    $validated['estado_pago'],

                    'monto_pagado' =>
                    $validated['monto_pagado'],

                    'saldo_pendiente' =>
                    $saldoPendiente,

                    'observacion' =>
                    $validated['observacion'] ?? null,

                ]);


                foreach ($productos as $item) {

                    $venta->detalles()->create([

                        'producto_id' =>
                        $item['producto']->id,

                        'cantidad' =>
                        $item['cantidad'],

                        'precio_unitario' =>
                        $item['precio_unitario'],

                        'precio_total' =>
                        $item['precio_total'],

                    ]);


                    Movimiento::create([

                        'producto_id' =>
                        $item['producto']->id,

                        'tipo' =>
                        'SALIDA',

                        'cantidad' =>
                        $item['cantidad'],

                        'fecha' =>
                        $validated['fecha'] ?? now(),

                        'observacion' =>
                        'Salida por venta #' . $venta->id,

                    ]);
                }


                if ($validated['monto_pagado'] > 0) {

                    $venta->pagos()->create([

                        'monto' =>
                        $validated['monto_pagado'],

                        'medio_pago' =>
                        $validated['medio_pago'],

                        'medio_pago_otro' =>
                        $validated['medio_pago_otro'] ?? null,

                        'fecha' =>
                        $validated['fecha'] ?? now(),

                        'observacion' =>
                        'Pago inicial de la venta #' . $venta->id,

                    ]);
                }


                return $venta;
            });


            return response()->json([

                'success' => true,

                'message' =>
                'Venta registrada correctamente.',

                'data' =>
                $venta->load('detalles.producto')

            ], 201);
        } catch (\Throwable $e) {

            return response()->json([

                'success' => false,

                'message' =>
                'No se pudo registrar la venta.',

                'error' =>
                $e->getMessage()

            ], 422);
        }
    }
    public function show(Request $request, Venta $venta)
    {
        $venta->load([
            'detalles.producto',
            'pagos'
        ]);

        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
                'data' => $venta
            ]);
        }

        return view(
            'ventas.show',
            compact('venta')
        );
    }
    public function anular(Venta $venta)
    {
        if ($venta->estado === 'ANULADA') {

            return redirect()
                ->route('ventas.index')
                ->with('error', 'La venta ya está anulada.');
        }

        try {

            DB::transaction(function () use ($venta) {

                $venta = Venta::where('id', $venta->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($venta->estado === 'ANULADA') {

                    throw new \Exception(
                        'La venta ya está anulada.'
                    );
                }

                $venta->load('detalles');

                foreach ($venta->detalles as $detalle) {

                    $producto = Producto::where(
                        'id',
                        $detalle->producto_id
                    )
                        ->lockForUpdate()
                        ->firstOrFail();

                    Movimiento::create([
                        'producto_id' => $producto->id,
                        'tipo' => 'ENTRADA',
                        'cantidad' => $detalle->cantidad,
                        'fecha' => now(),
                        'observacion' =>
                        'Devolución por anulación de venta #' .
                            $venta->id,
                    ]);
                }

                $venta->update([
                    'estado' => 'ANULADA'
                ]);
            });

            // REGRESA AL INDEX DE VENTAS
            return redirect()
                ->route('ventas.index')
                ->with('success', 'Venta anulada correctamente.');
        } catch (\Throwable $e) {

            return redirect()
                ->route('ventas.index')
                ->with(
                    'error',
                    'No se pudo anular la venta: ' . $e->getMessage()
                );
        }
    }
    public function create()
    {
        return view('ventas.create');
    }
}
