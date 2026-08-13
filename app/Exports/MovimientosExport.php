<?php

namespace App\Exports;

use App\Models\Movimiento;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MovimientosExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    protected $fechaInicio;
    protected $fechaFin;
    protected $tipo;

    public function __construct(
        $fechaInicio = null,
        $fechaFin = null,
        $tipo = null
    ) {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->tipo = $tipo;
    }

    public function collection()
    {
        $query = Movimiento::with('producto')
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

        if ($this->tipo) {
            $query->where(
                'tipo',
                $this->tipo
            );
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Fecha',
            'Código',
            'Descripción',
            'Tipo',
            'Cantidad',
            'Observación',
        ];
    }

    public function map($movimiento): array
    {
        return [
            $movimiento->id,
            optional($movimiento->fecha)->format('d/m/Y H:i'),
            $movimiento->producto->codigo ?? '',
            $movimiento->producto->descripcion ?? '',
            $movimiento->tipo,
            $movimiento->cantidad,
            $movimiento->observacion ?? '',
        ];
    }
}