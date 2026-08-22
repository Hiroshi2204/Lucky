<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    public function run()
    {
        Rol::updateOrCreate(
            ['id' => 1],
            [
                'nombre' => 'ADMINISTRADOR',
                'estado_registro' => 'A',
            ]
        );

        Rol::updateOrCreate(
            ['id' => 2],
            [
                'nombre' => 'TRABAJADOR',
                'estado_registro' => 'A',
            ]
        );
    }
}