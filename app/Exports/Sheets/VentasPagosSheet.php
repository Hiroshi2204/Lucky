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

class VentasPagosSheet implements
    FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles, WithColumnFormatting, ShouldAutoSize
{
    use EstiloReporte;

    protected $registros;

    public function __construct($ventas)
    {
        $this->registros = $ventas->flatMap(
            fn($venta) => $venta->pagos->map(fn($p) => ['venta' => $venta, 'pago' => $p])
        )->sortByDesc(fn($r) => $r['pago']->fecha)->values();
    }

    public function title(): string
    {
        return 'Pagos';
    }

    public function collection()
    {
        return $this->registros;
    }

    public function headings(): array
    {
        return [
            'N.º Venta', 'Fecha de Pago', 'Medio de Pago', 'Monto',
            'Total Venta', 'Estado de Pago (Venta)', 'Observación',
        ];
    }

    public function map($r): array
    {
        return [
            $r['venta']->id,
            optional($r['pago']->fecha)->format('d/m/Y H:i'),
            $this->medioPago($r['pago']),
            (float) $r['pago']->monto,
            (float) $r['venta']->total,
            $r['venta']->estado_pago,
            $r['pago']->observacion ?? '',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => $this->formatoMoneda,
            'E' => $this->formatoMoneda,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $this->estilizarTabla($sheet, 'G', $this->registros->count() + 1);

        foreach ($this->registros as $i => $r) {
            $this->colorearEstado($sheet, 'F' . ($i + 2), $r['venta']->estado_pago);
        }

        return [];
    }
}