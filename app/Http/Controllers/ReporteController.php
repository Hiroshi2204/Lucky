<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Movimiento;
use App\Models\Venta;
use App\Models\Pago;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\InventarioExport;
use App\Exports\MovimientosExport;
use App\Exports\VentasExport;
use App\Exports\PagosExport;
use App\Helpers\LocalHelper;

class ReporteController extends Controller
{
    /**
     * PANEL PRINCIPAL DE REPORTES
     */
    public function index()
    {
        return view('reportes.index');
    }


    /**
     * ============================================================
     * INVENTARIO
     * ============================================================
     */

    public function inventario(Request $request)
    {
        $localId = LocalHelper::id();

        $query = Producto::query()
            ->where('local_id', $localId);

        if ($request->filled('buscar')) {

            $buscar = $request->buscar;

            $query->where(function ($q) use ($buscar) {

                $q->where(
                    'codigo',
                    'LIKE',
                    "%{$buscar}%"
                )
                    ->orWhere(
                        'descripcion',
                        'LIKE',
                        "%{$buscar}%"
                    );
            });
        }

        if ($request->has('estado')) {

            $query->where(
                'estado',
                $request->estado
            );
        }

        $productos = $query
            ->orderBy('codigo')
            ->get();

        return view(
            'reportes.inventario',
            compact('productos')
        );
    }


    /**
     * INVENTARIO PDF
     */
    public function inventarioPdf(Request $request)
    {
        $localId = LocalHelper::id();

        $query = Producto::query()
            ->where('local_id', $localId);

        if ($request->filled('estado')) {

            $query->where(
                'estado',
                $request->estado
            );
        }

        $productos = $query
            ->orderBy('codigo')
            ->get();

        $pdf = Pdf::loadView(
            'reportes.pdf.inventario',
            compact('productos')
        );

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download(
            'reporte-inventario-' .
                now()->format('Y-m-d') .
                '.pdf'
        );
    }


    /**
     * INVENTARIO EXCEL
     */
    public function inventarioExcel(Request $request)
    {
        return Excel::download(
            new InventarioExport(
                $request->estado
            ),
            'reporte_inventario.xlsx'
        );
    }


    /**
     * ============================================================
     * MOVIMIENTOS
     * ============================================================
     */

    public function movimientos(Request $request)
    {
        $localId = LocalHelper::id();

        $query = Movimiento::with('producto')
            ->where('local_id', $localId)
            ->orderBy('fecha', 'desc');

        if ($request->filled('tipo')) {

            $query->where(
                'tipo',
                $request->tipo
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

        $movimientos = $query->get();

        return view(
            'reportes.movimientos',
            compact('movimientos')
        );
    }


    /**
     * MOVIMIENTOS PDF
     */
    public function movimientosPdf(Request $request)
    {
        $localId = LocalHelper::id();

        $query = Movimiento::with('producto')
            ->where('local_id', $localId)
            ->orderBy('fecha', 'desc');

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

        if ($request->filled('tipo')) {
            $query->where(
                'tipo',
                $request->tipo
            );
        }

        $movimientos = $query->get();

        $pdf = Pdf::loadView(
            'reportes.pdf.movimientos',
            compact('movimientos')
        );

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download(
            'reporte-movimientos-' .
                now()->format('Y-m-d') .
                '.pdf'
        );
    }


    /**
     * MOVIMIENTOS EXCEL
     */
    public function movimientosExcel(Request $request)
    {
        return Excel::download(
            new MovimientosExport(
                $request->fecha_inicio,
                $request->fecha_fin,
                $request->tipo
            ),
            'reporte_movimientos.xlsx'
        );
    }


    /**
     * ============================================================
     * VENTAS
     * ============================================================
     */

    public function ventas(Request $request)
    {
        $localId = LocalHelper::id();

        $query = Venta::with([
            'detalles.producto',
            'pagos'
        ])
            ->where('local_id', $localId)
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

        if ($request->filled('estado')) {

            $query->where(
                'estado',
                $request->estado
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

        $ventas = $query->get();

        return view(
            'reportes.ventas',
            compact('ventas')
        );
    }


    /**
     * VENTAS PDF
     */
    public function ventasPdf(Request $request)
    {
        $localId = LocalHelper::id();

        $query = Venta::with([
            'detalles.producto',
            'pagos'
        ])
            ->where('local_id', $localId)
            ->orderBy('fecha', 'desc');

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

        if ($request->filled('medio_pago')) {
            $query->where(
                'medio_pago',
                $request->medio_pago
            );
        }

        if ($request->filled('estado')) {
            $query->where(
                'estado',
                $request->estado
            );
        }

        if ($request->filled('estado_pago')) {
            $query->where(
                'estado_pago',
                $request->estado_pago
            );
        }

        $ventas = $query->get();

        /*
    |--------------------------------------------------------------------------
    | FILTROS
    |--------------------------------------------------------------------------
    */

        $filtros = [
            'fecha_inicio' => $request->input('fecha_inicio'),
            'fecha_fin'    => $request->input('fecha_fin'),
            'medio_pago'   => $request->input('medio_pago'),
            'estado'       => $request->input('estado'),
            'estado_pago'  => $request->input('estado_pago'),
        ];

        $pdf = Pdf::loadView(
            'reportes.pdf.ventas',
            compact(
                'ventas',
                'filtros'
            )
        );

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download(
            'reporte-ventas-' .
                now()->format('Y-m-d') .
                '.pdf'
        );
    }


    /**
     * VENTAS EXCEL
     */
    public function ventasExcel(Request $request)
    {
        return Excel::download(
            new VentasExport(
                $request->fecha_inicio,
                $request->fecha_fin,
                $request->estado,
                $request->estado_pago,
                $request->medio_pago
            ),
            'reporte_ventas.xlsx'
        );
    }


    /**
     * ============================================================
     * PAGOS
     * ============================================================
     */

    public function pagosPdf(Request $request)
    {
        $localId = LocalHelper::id();

        $query = Pago::with('venta')
            ->whereHas('venta', function ($q) use ($localId) {

                $q->where('estado', 'ACTIVA')
                    ->where('local_id', $localId);
            })
            ->orderBy('fecha', 'desc');


        /*
    |--------------------------------------------------------------------------
    | FILTRO FECHA INICIO
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
    | FILTRO FECHA FIN
    |--------------------------------------------------------------------------
    */

        if ($request->filled('fecha_fin')) {

            $query->whereDate(
                'fecha',
                '<=',
                $request->fecha_fin
            );
        }


        /*
    |--------------------------------------------------------------------------
    | FILTRO MEDIO DE PAGO
    |--------------------------------------------------------------------------
    */

        if ($request->filled('medio_pago')) {

            $query->where(
                'medio_pago',
                $request->medio_pago
            );
        }


        /*
    |--------------------------------------------------------------------------
    | OBTENER PAGOS
    |--------------------------------------------------------------------------
    */

        $pagos = $query->get();


        /*
    |--------------------------------------------------------------------------
    | TOTAL
    |--------------------------------------------------------------------------
    */

        $totalPagos = $pagos->sum('monto');


        /*
    |--------------------------------------------------------------------------
    | FILTROS PARA EL PDF
    |--------------------------------------------------------------------------
    */

        $filtros = [

            'fecha_inicio' => $request->input('fecha_inicio'),

            'fecha_fin' => $request->input('fecha_fin'),

            'medio_pago' => $request->input('medio_pago'),

        ];


        /*
    |--------------------------------------------------------------------------
    | GENERAR PDF
    |--------------------------------------------------------------------------
    */

        $pdf = Pdf::loadView(
            'reportes.pdf.pagos',
            compact(
                'pagos',
                'totalPagos',
                'filtros'
            )
        );


        $pdf->setPaper('a4', 'landscape');


        return $pdf->download(
            'reporte-pagos-' .
                now()->format('Y-m-d') .
                '.pdf'
        );
    }

    /**
     * PAGOS EXCEL
     */
    public function pagosExcel(Request $request)
    {
        return Excel::download(
            new PagosExport(
                $request->fecha_inicio,
                $request->fecha_fin,
                $request->medio_pago
            ),
            'reporte_pagos.xlsx'
        );
    }
}
