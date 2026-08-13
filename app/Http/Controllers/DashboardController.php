<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * API
     */
    public function index(Request $request)
    {
        $data = $this->obtenerDatos($request);

        return response()->json([
            'success' => true,
            ...$data
        ]);
    }


    /**
     * VISTA WEB
     */
    public function vista(Request $request)
    {
        $data = $this->obtenerDatos($request);

        return view('dashboard.index', $data);
    }


    /**
     * Obtener información del dashboard
     */
    private function obtenerDatos(Request $request)
    {
        $stockMinimo = $request->input(
            'stock_minimo',
            50
        );


        /*
        |--------------------------------------------------------------------------
        | PRODUCTOS
        |--------------------------------------------------------------------------
        */

        $totalProductos = Producto::where(
            'estado',
            true
        )->count();


        /*
        |--------------------------------------------------------------------------
        | STOCK
        |--------------------------------------------------------------------------
        */

        $productosStock = Producto::where(
            'estado',
            true
        )
        ->withSum([
            'movimientos as entradas' => function ($query) {
                $query->where('tipo', 'ENTRADA');
            }
        ], 'cantidad')
        ->withSum([
            'movimientos as salidas' => function ($query) {
                $query->where('tipo', 'SALIDA');
            }
        ], 'cantidad')
        ->get();


        $stockTotal = 0;

        $productosStockBajo = 0;

        $productosPocoStock = collect();


        foreach ($productosStock as $producto) {

            $entradas =
                (float) ($producto->entradas ?? 0);

            $salidas =
                (float) ($producto->salidas ?? 0);

            $stock =
                $entradas - $salidas;


            $stockTotal += $stock;


            /*
             * Guardamos el stock calculado
             * para utilizarlo en Blade.
             */

            $producto->stock_actual = $stock;


            if ($stock <= $stockMinimo) {

                $productosStockBajo++;

                $productosPocoStock->push(
                    $producto
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | FECHAS
        |--------------------------------------------------------------------------
        */

        $hoy = now()->toDateString();

        $inicioMes =
            now()->startOfMonth()->toDateString();

        $finMes =
            now()->endOfMonth()->toDateString();


        /*
        |--------------------------------------------------------------------------
        | VENTAS DEL DÍA
        |--------------------------------------------------------------------------
        */

        $ventasHoy = Venta::where(
            'estado',
            'ACTIVA'
        )
        ->whereDate(
            'fecha',
            $hoy
        )
        ->get();


        /*
        |--------------------------------------------------------------------------
        | VENTAS DEL MES
        |--------------------------------------------------------------------------
        */

        $ventasMes = Venta::where(
            'estado',
            'ACTIVA'
        )
        ->whereBetween(
            'fecha',
            [
                $inicioMes . ' 00:00:00',
                $finMes . ' 23:59:59'
            ]
        )
        ->get();


        /*
        |--------------------------------------------------------------------------
        | VENTAS DEL DÍA
        |--------------------------------------------------------------------------
        */

        $ventasDiaTotal =
            $ventasHoy->sum('total');

        $cobradoDia =
            $ventasHoy->sum('monto_pagado');

        $pendienteDia =
            $ventasHoy->sum('saldo_pendiente');


        /*
        |--------------------------------------------------------------------------
        | VENTAS DEL MES
        |--------------------------------------------------------------------------
        */

        $ventasMesTotal =
            $ventasMes->sum('total');

        $cobradoMes =
            $ventasMes->sum('monto_pagado');

        $pendienteMes =
            $ventasMes->sum('saldo_pendiente');


        /*
        |--------------------------------------------------------------------------
        | MEDIOS DE PAGO
        |--------------------------------------------------------------------------
        */

        $ventasPorMedioPago =
            $ventasMes
                ->groupBy('medio_pago')
                ->map(function ($ventas) {

                    return [

                        'cantidad' =>
                            $ventas->count(),

                        'total' =>
                            round(
                                $ventas->sum('total'),
                                2
                            ),

                        'cobrado' =>
                            round(
                                $ventas->sum('monto_pagado'),
                                2
                            ),

                        'pendiente' =>
                            round(
                                $ventas->sum(
                                    'saldo_pendiente'
                                ),
                                2
                            )
                    ];
                });


        /*
        |--------------------------------------------------------------------------
        | VENTAS ÚLTIMOS 7 DÍAS
        |--------------------------------------------------------------------------
        */

        $ventasUltimos7Dias = collect();


        for ($i = 6; $i >= 0; $i--) {

            $fecha = now()
                ->subDays($i)
                ->toDateString();


            $total = Venta::where(
                'estado',
                'ACTIVA'
            )
            ->whereDate(
                'fecha',
                $fecha
            )
            ->sum('total');


            $ventasUltimos7Dias->push([

                'fecha' => $fecha,

                'total' =>
                    round(
                        $total,
                        2
                    )
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | DATOS
        |--------------------------------------------------------------------------
        */

        return [

            /*
            |--------------------------------------------------------------------------
            | DATOS PARA API
            |--------------------------------------------------------------------------
            */

            'fecha' =>
                now()->format(
                    'Y-m-d H:i:s'
                ),


            'productos' => [

                'total' =>
                    $totalProductos,

                'stock_total' =>
                    round(
                        $stockTotal,
                        3
                    ),

                'stock_minimo' =>
                    $stockMinimo,

                'stock_bajo' =>
                    $productosStockBajo,
            ],


            'ventas_hoy' => [

                'cantidad' =>
                    $ventasHoy->count(),

                'total' =>
                    round(
                        $ventasDiaTotal,
                        2
                    ),

                'cobrado' =>
                    round(
                        $cobradoDia,
                        2
                    ),

                'pendiente' =>
                    round(
                        $pendienteDia,
                        2
                    ),
            ],


            'ventas_mes' => [

                'cantidad' =>
                    $ventasMes->count(),

                'total' =>
                    round(
                        $ventasMesTotal,
                        2
                    ),

                'cobrado' =>
                    round(
                        $cobradoMes,
                        2
                    ),

                'pendiente' =>
                    round(
                        $pendienteMes,
                        2
                    ),
            ],


            'ventas_por_medio_pago' =>
                $ventasPorMedioPago,


            'ventas_ultimos_7_dias' =>
                $ventasUltimos7Dias,


            /*
            |--------------------------------------------------------------------------
            | VARIABLES PARA BLADE
            |--------------------------------------------------------------------------
            */

            'totalProductos' =>
                $totalProductos,

            'stockTotal' =>
                $stockTotal,

            'stockMinimo' =>
                $stockMinimo,

            'productosPocoStock' =>
                $productosPocoStock,

            'ventasHoy' =>
                $ventasDiaTotal,

            'ventasMes' =>
                $ventasMesTotal,

            'dineroCobrado' =>
                $cobradoMes,

            'dineroPendiente' =>
                $pendienteMes,

            'ventasUltimos7Dias' =>
                $ventasUltimos7Dias,
        ];
    }
}