<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EntradaController extends Controller
{
    /**
     * LISTAR ENTRADAS
     */
    public function index(Request $request)
    {
        $query = Movimiento::with('producto')
            ->where('tipo', 'ENTRADA')
            ->orderBy('fecha', 'desc');

        /*
        |--------------------------------------------------------------------------
        | FILTRAR POR PRODUCTO
        |--------------------------------------------------------------------------
        */

        if ($request->filled('producto_id')) {

            $query->where(
                'producto_id',
                $request->producto_id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRAR FECHA INICIO
        |--------------------------------------------------------------------------
        */

        if ($request->filled('fecha_inicio')) {

            $query->whereDate(
                'fecha',
                '>=',
                $request->fecha_inicio
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRAR FECHA FIN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('fecha_fin')) {

            $query->whereDate(
                'fecha',
                '<=',
                $request->fecha_fin
            );
        }

        $entradas = $query
            ->paginate(30)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | API
        |--------------------------------------------------------------------------
        */

        if ($request->expectsJson()) {

            return response()->json([
                'success' => true,
                'data' => $entradas
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | BLADE
        |--------------------------------------------------------------------------
        */

        $productos = Producto::where('estado', true)
            ->orderBy('codigo')
            ->get();

        return view(
            'entradas.index',
            compact(
                'entradas',
                'productos'
            )
        );
    }


    /**
     * FORMULARIO PARA REGISTRAR ENTRADA
     */

    public function create()
    {
        return view('entradas.create');
    }


    /**
     * REGISTRAR ENTRADA
     */
    /**
     * REGISTRAR ENTRADA
     */
    public function store(Request $request)
    {
        /*
    |--------------------------------------------------------------------------
    | VALIDACIÓN BÁSICA
    |--------------------------------------------------------------------------
    */

        $request->validate([

            'codigo' => [
                'required',
                'string',
                'max:100'
            ],

            'cantidad' => [
                'required',
                'numeric',
                'gt:0'
            ],

            'observacion' => [
                'nullable',
                'string'
            ],

        ], [

            'codigo.required' =>
            'El código del producto es obligatorio.',

            'cantidad.required' =>
            'La cantidad es obligatoria.',

            'cantidad.numeric' =>
            'La cantidad debe ser numérica.',

            'cantidad.gt' =>
            'La cantidad debe ser mayor que cero.',
        ]);


        try {

            $resultado = DB::transaction(function () use ($request) {

                /*
            |--------------------------------------------------------------------------
            | BUSCAR PRODUCTO
            |--------------------------------------------------------------------------
            */

                $producto = Producto::where(
                    'codigo',
                    trim($request->codigo)
                )
                    ->lockForUpdate()
                    ->first();


                /*
            |--------------------------------------------------------------------------
            | PRODUCTO EXISTENTE
            |--------------------------------------------------------------------------
            */

                if ($producto) {

                    /*
                |--------------------------------------------------------------------------
                | VERIFICAR ESTADO
                |--------------------------------------------------------------------------
                */

                    if (!$producto->estado) {

                        throw new \Exception(
                            "El producto {$producto->codigo} está inactivo."
                        );
                    }


                    /*
                |--------------------------------------------------------------------------
                | NO MODIFICAMOS:
                | - descripción
                | - espesor
                |--------------------------------------------------------------------------
                */

                    $productoNuevo = false;
                }

                /*
            |--------------------------------------------------------------------------
            | PRODUCTO NUEVO
            |--------------------------------------------------------------------------
            */ else {

                    /*
                |--------------------------------------------------------------------------
                | AHORA SÍ EXIGIMOS DESCRIPCIÓN Y ESPESOR
                |--------------------------------------------------------------------------
                */

                    if (
                        is_null($request->descripcion) ||
                        trim($request->descripcion) === ''
                    ) {

                        throw new \Exception(
                            'La descripción es obligatoria para un producto nuevo.'
                        );
                    }


                    if (
                        is_null($request->espesor) ||
                        $request->espesor === ''
                    ) {

                        throw new \Exception(
                            'El espesor es obligatorio para un producto nuevo.'
                        );
                    }


                    if (!is_numeric($request->espesor)) {

                        throw new \Exception(
                            'El espesor debe ser numérico.'
                        );
                    }


                    if ((float) $request->espesor < 0) {

                        throw new \Exception(
                            'El espesor no puede ser negativo.'
                        );
                    }


                    /*
                |--------------------------------------------------------------------------
                | CREAR PRODUCTO
                |--------------------------------------------------------------------------
                */

                    $producto = Producto::create([

                        'codigo' =>
                        trim($request->codigo),

                        'descripcion' =>
                        trim($request->descripcion),

                        'espesor' =>
                        $request->espesor,

                        'estado' =>
                        true,
                    ]);


                    $productoNuevo = true;
                }


                /*
            |--------------------------------------------------------------------------
            | REGISTRAR MOVIMIENTO DE ENTRADA
            |--------------------------------------------------------------------------
            */

                $movimiento = Movimiento::create([

                    'producto_id' =>
                    $producto->id,

                    'tipo' =>
                    'ENTRADA',

                    'cantidad' =>
                    $request->cantidad,

                    'fecha' =>
                    now(),

                    'observacion' =>
                    $request->observacion ?: null,
                ]);


                /*
            |--------------------------------------------------------------------------
            | STOCK ACTUAL
            |--------------------------------------------------------------------------
            */

                $producto->refresh();

                $stockActual =
                    $producto->stock_actual;


                return [

                    'producto' =>
                    $producto,

                    'movimiento' =>
                    $movimiento,

                    'producto_nuevo' =>
                    $productoNuevo,

                    'stock_actual' =>
                    $stockActual,
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
                    $resultado['producto_nuevo']
                        ? 'Producto creado y entrada registrada correctamente.'
                        : 'Entrada registrada correctamente.',

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
                ->route('entradas.index')
                ->with(
                    'success',
                    $resultado['producto_nuevo']
                        ? 'Producto creado y entrada registrada correctamente.'
                        : 'Entrada registrada correctamente.'
                );
        } catch (\Throwable $e) {

            /*
        |--------------------------------------------------------------------------
        | API
        |--------------------------------------------------------------------------
        */

            if ($request->expectsJson()) {

                return response()->json([

                    'success' => false,

                    'message' =>
                    'No se pudo registrar la entrada.',

                    'error' =>
                    $e->getMessage()

                ], 422);
            }


            /*
        |--------------------------------------------------------------------------
        | BLADE
        |--------------------------------------------------------------------------
        */

            return back()
                ->withInput()
                ->withErrors([
                    'entrada' =>
                    $e->getMessage()
                ]);
        }
    }


    /**
     * MOSTRAR ENTRADA
     */
    public function show(
        Request $request,
        Movimiento $entrada
    ) {

        if ($entrada->tipo !== 'ENTRADA') {

            if ($request->expectsJson()) {

                return response()->json([

                    'success' => false,

                    'message' =>
                    'El movimiento indicado no es una entrada.'

                ], 422);
            }

            abort(404);
        }


        $entrada->load('producto');

        $stock = $entrada
            ->producto
            ->stock_actual;


        /*
        |--------------------------------------------------------------------------
        | API
        |--------------------------------------------------------------------------
        */

        if ($request->expectsJson()) {

            return response()->json([

                'success' => true,

                'data' => [

                    'id' =>
                    $entrada->id,

                    'producto' =>
                    $entrada->producto,

                    'cantidad' =>
                    $entrada->cantidad,

                    'fecha' =>
                    $entrada->fecha,

                    'observacion' =>
                    $entrada->observacion,

                    'stock_actual' =>
                    $stock,
                ]

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | BLADE
        |--------------------------------------------------------------------------
        */

        return view(
            'entradas.show',
            compact(
                'entrada',
                'stock'
            )
        );
    }
}
