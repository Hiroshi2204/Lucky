<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Local;

class LocalSeeder extends Seeder
{
    public function run()
    {
        Local::updateOrCreate(
            ['codigo' => 'LOCAL-01'],
            [
                'nombre' => 'Local 01',
                'direccion' => null,
                'telefono' => null,
                'estado' => true,
            ]
        );

        Local::updateOrCreate(
            ['codigo' => 'LOCAL-02'],
            [
                'nombre' => 'Local 02',
                'direccion' => null,
                'telefono' => null,
                'estado' => true,
            ]
        );
    }
}