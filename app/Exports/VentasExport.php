<?php

namespace App\Exports;

use App\Exports\Sheets\VentasResumenSheet;
use App\Exports\Sheets\VentasListadoSheet;
use App\Exports\Sheets\VentasProductosSheet;
use App\Exports\Sheets\VentasPagosSheet;
use App\Models\Venta;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class VentasExport implements WithMultipleSheets
{
    public function __construct(
        protected $fechaInicio = null,
        protected $fechaFin = null,
        protected $estado = null,
        protected $estadoPago = null,
        protected $medioPago = null
    ) {}

    public function sheets(): array
    {
        $query = Venta::with(['detalles.producto', 'pagos'])
            ->orderBy('fecha', 'desc');

        if ($this->fechaInicio) $query->whereDate('fecha', '>=', $this->fechaInicio);
        if ($this->fechaFin)    $query->whereDate('fecha', '<=', $this->fechaFin);
        if ($this->estado)      $query->where('estado', $this->estado);
        if ($this->estadoPago)  $query->where('estado_pago', $this->estadoPago);
        if ($this->medioPago)   $query->where('medio_pago', $this->medioPago);

        $ventas = $query->get();

        $filtros = [
            'Desde'          => $this->fechaInicio,
            'Hasta'          => $this->fechaFin,
            'Estado'         => $this->estado,
            'Estado de pago' => $this->estadoPago,
            'Medio de pago'  => $this->medioPago,
        ];

        return [
            new VentasResumenSheet($ventas, $filtros),
            new VentasListadoSheet($ventas),
            new VentasProductosSheet($ventas),
            new VentasPagosSheet($ventas),
        ];
    }
}