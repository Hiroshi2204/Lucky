<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PlantillaEntradasExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'codigo',
            'descripcion',
            'espesor',
            'cantidad',
        ];
    }

    public function array(): array
    {
        return [
            [
                'P001',
                'Producto ejemplo',
                0.010,
                100,
            ],
        ];
    }
}
