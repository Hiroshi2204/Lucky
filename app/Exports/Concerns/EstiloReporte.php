<?php

namespace App\Exports\Concerns;

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

trait EstiloReporte
{
    protected string $formatoMoneda = '"S/" #,##0.00';

    protected function estilizarTabla(Worksheet $sheet, string $ultimaCol, int $ultimaFila): void
    {
        $sheet->getStyle("A1:{$ultimaCol}1")->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F3864']],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrapText'   => true,
            ],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(26);

        if ($ultimaFila > 1) {
            $sheet->getStyle("A2:{$ultimaCol}{$ultimaFila}")->applyFromArray([
                'borders' => ['allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'D9D9D9'],
                ]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
            ]);

            // Zebra
            for ($i = 3; $i <= $ultimaFila; $i += 2) {
                $sheet->getStyle("A{$i}:{$ultimaCol}{$i}")->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('F2F6FC');
            }
        }

        $sheet->freezePane('A2');
        $sheet->setAutoFilter("A1:{$ultimaCol}{$ultimaFila}");
    }

    protected function medioPago($modelo): string
    {
        return $modelo->medio_pago === 'OTRO'
            ? ($modelo->medio_pago_otro ?: 'OTRO')
            : (string) $modelo->medio_pago;
    }

    protected function colorearEstado(Worksheet $sheet, string $celda, ?string $estado): void
    {
        $estado = strtoupper((string) $estado);

        $color = match (true) {
            str_contains($estado, 'ANUL')  => ['C00000', 'FDE9E7'],
            str_contains($estado, 'PAGAD') => ['2E7D32', 'E8F5E9'],
            str_contains($estado, 'PARC')  => ['B26A00', 'FFF4E0'],
            str_contains($estado, 'PEND')  => ['C00000', 'FDE9E7'],
            default => null,
        };

        if ($color) {
            $sheet->getStyle($celda)->applyFromArray([
                'font' => ['bold' => true, 'color' => ['rgb' => $color[0]]],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $color[1]]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ]);
        }
    }
}