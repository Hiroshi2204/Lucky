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

class VentasProductosSheet implements
    FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles, WithColumnFormatting, ShouldAutoSize
{
    use EstiloReporte;

    protected $lineas;

    public function __construct($ventas)
    {
        $this->lineas = $ventas->flatMap(
            fn($venta) => $venta->detalles->map(fn($d) => ['venta' => $venta, 'detalle' => $d])
        )->values();
    }

    public function title(): string
    {
        return 'Detalle productos';
    }

    public function collection()
    {
        return $this->lineas;
    }

    public function headings(): array
    {
        return [
            'N.º Venta', 'Fecha', 'Código', 'Producto', 'Cantidad',
            'Precio Unitario', 'Total Línea', 'Medio de Pago', 'Estado Venta',
        ];
    }

    public function map($linea): array
    {
        $venta = $linea['venta'];
        $d = $linea['detalle'];

        return [
            $venta->id,
            optional($venta->fecha)->format('d/m/Y H:i'),
            $d->producto->codigo ?? '-',
            $d->producto->descripcion ?? 'Producto eliminado',
            (float) $d->cantidad,
            (float) $d->precio_unitario,
            (float) $d->precio_total,
            $this->medioPago($venta),
            $venta->estado,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'E' => '#,##0.000',
            'F' => $this->formatoMoneda,
            'G' => $this->formatoMoneda,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $this->estilizarTabla($sheet, 'I', $this->lineas->count() + 1);

        foreach ($this->lineas as $i => $linea) {
            $this->colorearEstado($sheet, 'I' . ($i + 2), $linea['venta']->estado);
        }

        return [];
    }
}