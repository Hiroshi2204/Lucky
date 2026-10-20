<?php

namespace App\Exports\Sheets;

use App\Exports\Concerns\EstiloReporte;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VentasListadoSheet implements
    FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles, WithColumnFormatting, ShouldAutoSize
{
    use EstiloReporte;

    public function __construct(protected $ventas) {}

    public function title(): string
    {
        return 'Ventas';
    }

    public function collection()
    {
        return $this->ventas;
    }

    public function headings(): array
    {
        return [
            'N.º Venta', 'Fecha', 'N.º Ítems', 'Descuento', 'Total',
            'Medio de Pago', 'Estado de Pago', 'Monto Pagado',
            'Saldo Pendiente', 'N.º Pagos', 'Estado', 'Observación',
        ];
    }

    public function map($venta): array
    {
        return [
            $venta->id,
            optional($venta->fecha)->format('d/m/Y H:i'),
            $venta->detalles->count(),
            (float) $venta->descuento,
            (float) $venta->total,
            $this->medioPago($venta),
            $venta->estado_pago,
            (float) $venta->monto_pagado,
            (float) $venta->saldo_pendiente,
            $venta->pagos->count(),
            $venta->estado,
            $venta->observacion ?? '',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => $this->formatoMoneda,
            'E' => $this->formatoMoneda,
            'H' => $this->formatoMoneda,
            'I' => $this->formatoMoneda,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $ultima = $this->ventas->count() + 1;
        $this->estilizarTabla($sheet, 'L', $ultima);

        foreach ($this->ventas as $i => $venta) {
            $fila = $i + 2;
            $this->colorearEstado($sheet, "G{$fila}", $venta->estado_pago);
            $this->colorearEstado($sheet, "K{$fila}", $venta->estado);
        }

        return [];
    }
}