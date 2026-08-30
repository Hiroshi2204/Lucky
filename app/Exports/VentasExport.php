<?php

namespace App\Exports;

use App\Models\Venta;
use App\Helpers\LocalHelper;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VentasExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    protected $fechaInicio;
    protected $fechaFin;
    protected $estado;
    protected $estadoPago;
    protected $medioPago;

    public function __construct(
        $fechaInicio = null,
        $fechaFin = null,
        $estado = null,
        $estadoPago = null,
        $medioPago = null
    ) {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->estado = $estado;
        $this->estadoPago = $estadoPago;
        $this->medioPago = $medioPago;
    }

    public function collection()
    {
        $localId = LocalHelper::id();

        $query = Venta::query()
            ->where('local_id', $localId)
            ->orderBy('fecha', 'desc');

        if ($this->fechaInicio) {
            $query->whereDate(
                'fecha',
                '>=',
                $this->fechaInicio
            );
        }

        if ($this->fechaFin) {
            $query->whereDate(
                'fecha',
                '<=',
                $this->fechaFin
            );
        }

        if ($this->estado) {
            $query->where(
                'estado',
                $this->estado
            );
        }

        if ($this->estadoPago) {
            $query->where(
                'estado_pago',
                $this->estadoPago
            );
        }

        if ($this->medioPago) {
            $query->where(
                'medio_pago',
                $this->medioPago
            );
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'N.º Venta',
            'Fecha',
            'Total',
            'Medio de Pago',
            'Estado de Pago',
            'Monto Pagado',
            'Saldo Pendiente',
            'Estado',
            'Observación',
        ];
    }

    public function map($venta): array
    {
        return [
            $venta->id,

            optional($venta->fecha)
                ->format('d/m/Y H:i'),

            $venta->total,

            $venta->medio_pago === 'OTRO'
                ? ($venta->medio_pago_otro ?: 'OTRO')
                : $venta->medio_pago,

            $venta->estado_pago,

            $venta->monto_pagado,

            $venta->saldo_pendiente,

            $venta->estado,

            $venta->observacion ?? '',
        ];
    }
}