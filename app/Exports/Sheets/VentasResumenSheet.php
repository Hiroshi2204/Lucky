<?php

namespace App\Exports\Sheets;

use App\Exports\Concerns\EstiloReporte;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VentasResumenSheet implements FromArray, WithTitle, WithStyles, ShouldAutoSize
{
    use EstiloReporte;

    private array $filas = [];
    private array $secciones = [];   // filas de título de sección
    private array $cabeceras = [];   // filas de cabecera de tabla
    private array $moneda = [];      // celdas con formato moneda

    public function __construct(protected $ventas, protected array $filtros) {}

    public function title(): string
    {
        return 'Resumen';
    }

    private function add(array $celdas, array $moneda = []): int
    {
        $this->filas[] = $celdas;
        $n = count($this->filas);
        foreach ($moneda as $col) {
            $this->moneda[] = $col . $n;
        }
        return $n;
    }

    public function array(): array
    {
        $this->filas = $this->secciones = $this->cabeceras = $this->moneda = [];

        $validas = $this->ventas->where('estado', '!=', 'ANULADA');
        $anuladas = $this->ventas->count() - $validas->count();
        $totalVendido = (float) $validas->sum('total');

        $filtrosTxt = collect($this->filtros)->filter()
            ->map(fn($v, $k) => "$k: $v")->implode('  |  ') ?: 'Sin filtros (todas las ventas)';

        $this->add(['REPORTE DE VENTAS']);
        $this->add(['Generado: ' . now()->format('d/m/Y H:i')]);
        $this->add(['Filtros: ' . $filtrosTxt]);
        $this->add(['']);

        // ---- Indicadores
        $this->secciones[] = $this->add(['INDICADORES GENERALES']);
        $this->add(['Ventas registradas', $this->ventas->count()]);
        $this->add(['Ventas anuladas', $anuladas]);
        $this->add(['Ventas válidas', $validas->count()]);
        $this->add(['Monto total vendido', $totalVendido], ['B']);
        $this->add(['Total descuentos', (float) $validas->sum('descuento')], ['B']);
        $this->add(['Monto cobrado', (float) $validas->sum('monto_pagado')], ['B']);
        $this->add(['Saldo pendiente por cobrar', (float) $validas->sum('saldo_pendiente')], ['B']);
        $this->add(['']);

        // ---- Por medio de pago
        $this->secciones[] = $this->add(['VENTAS POR MEDIO DE PAGO']);
        $this->cabeceras[] = $this->add(['Medio de pago', 'N.º ventas', 'Monto vendido', 'Monto cobrado']);
        $validas->groupBy(fn($v) => $this->medioPago($v) ?: 'SIN DEFINIR')
            ->sortByDesc(fn($g) => $g->sum('total'))
            ->each(fn($g, $medio) => $this->add([
                $medio,
                $g->count(),
                (float) $g->sum('total'),
                (float) $g->sum('monto_pagado'),
            ], ['C', 'D']));
        $this->add(['']);

        // ---- Por estado de pago
        $this->secciones[] = $this->add(['VENTAS POR ESTADO DE PAGO']);
        $this->cabeceras[] = $this->add(['Estado de pago', 'N.º ventas', 'Monto vendido', 'Saldo pendiente']);
        $validas->groupBy(fn($v) => $v->estado_pago ?: 'SIN DEFINIR')
            ->each(fn($g, $estado) => $this->add([
                $estado,
                $g->count(),
                (float) $g->sum('total'),
                (float) $g->sum('saldo_pendiente'),
            ], ['C', 'D']));
        $this->add(['']);

        // ---- Top productos
        $this->secciones[] = $this->add(['TOP 10 PRODUCTOS MÁS VENDIDOS (por monto)']);
        $this->cabeceras[] = $this->add(['Código', 'Producto', 'Cantidad vendida', 'Monto']);
        $validas->flatMap(fn($v) => $v->detalles)
            ->groupBy('producto_id')
            ->map(function ($g) {
                $p = $g->first()->producto;
                return [
                    $p->codigo ?? '-',
                    $p->descripcion ?? 'Producto eliminado',
                    (float) $g->sum('cantidad'),
                    (float) $g->sum('precio_total'),
                ];
            })
            ->sortByDesc(fn($f) => $f[3])
            ->take(10)
            ->each(fn($f) => $this->add($f, ['D']));

        return $this->filas;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 18, 'color' => ['rgb' => '1F3864']],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('A3:D3');
        $sheet->getStyle('A2:A3')->getFont()->setItalic(true)->getColor()->setRGB('595959');

        foreach ($this->secciones as $fila) {
            $sheet->getStyle("A{$fila}:D{$fila}")->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F3864']],
            ]);
        }

        foreach ($this->cabeceras as $fila) {
            $sheet->getStyle("A{$fila}:D{$fila}")->applyFromArray([
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E2F3']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
        }

        foreach ($this->moneda as $celda) {
            $sheet->getStyle($celda)->getNumberFormat()->setFormatCode($this->formatoMoneda);
        }

        // Negrita en etiquetas de indicadores
        $sheet->getStyle('A6:A13')->getFont()->setBold(true);
        $sheet->getStyle('B6:B13')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);

        $sheet->getStyle('B15:D60')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        foreach ($this->cabeceras as $fila) {
            $sheet->getStyle("B{$fila}:D{$fila}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        }

        return [];
    }
}
