<?php

namespace App\Exports;

use App\Models\Producto;
use App\Helpers\LocalHelper;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class InventarioExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
{
    protected $estado;

    public function __construct($estado = null)
    {
        $this->estado = $estado;
    }

    public function collection()
    {
        $localId = LocalHelper::id();

        $query = Producto::query()
            ->where('local_id', $localId);

        if ($this->estado !== null && $this->estado !== '') {
            $query->where('estado', $this->estado);
        }

        return $query
            ->orderBy('codigo')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Código',
            'Descripción',
            'Espesor',
            'Stock Actual',
            'Estado',
        ];
    }

    public function map($producto): array
    {
        return [
            $producto->id,
            $producto->codigo,
            $producto->descripcion,
            $producto->espesor,
            $producto->stock_actual,
            $producto->estado ? 'ACTIVO' : 'INACTIVO',
        ];
    }
}