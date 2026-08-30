<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Local;

class LocalSeeder extends Seeder
{
    public function run()
    {
        Local::updateOrCreate(
            ['codigo' => 'Sd-Huancan'],
            [
                'nombre' => 'Sede Huancan',
                'direccion' => null,
                'telefono' => null,
                'estado' => true,
            ]
        );

        Local::updateOrCreate(
            ['codigo' => 'Sd-Tambo'],
            [
                'nombre' => 'Sede Tambo',
                'direccion' => null,
                'telefono' => null,
                'estado' => true,
            ]
        );
    }
}