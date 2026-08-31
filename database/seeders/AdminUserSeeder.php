<?php

namespace Database\Seeders;

use App\User;
use App\Models\Local;
use App\Models\Persona;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        /*
        |--------------------------------------------------------------------------
        | Persona
        |--------------------------------------------------------------------------
        */

        $persona1 = Persona::updateOrCreate(
            [
                'numero_documento' => '00000000',
            ],
            [
                'nombres' => 'Super Administrador',
                'apellido_paterno' => 'Sistema',
                'apellido_materno' => null,
                'celular' => null,
                'correo' => null,
                'tipo_documento_id' => null,
                'distrito_id' => null,
                'direccion' => null,
            ]
        );

        $persona2 = Persona::updateOrCreate(
            [
                'numero_documento' => '11111111',
            ],
            [
                'nombres' => 'Administrador',
                'apellido_paterno' => 'Sistema',
                'apellido_materno' => null,
                'celular' => null,
                'correo' => null,
                'tipo_documento_id' => null,
                'distrito_id' => null,
                'direccion' => null,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Usuario administrador
        |--------------------------------------------------------------------------
        |
        | admin123 continúa siendo la contraseña inicial.
        | must_change_password = true obliga a cambiarla al primer ingreso.
        |
        */

        $usuario1 = User::updateOrCreate(
            [
                'username' => 'admin',
            ],
            [
                'persona_id' => $persona1->id,
                'rol_id' => 1,
                'estado_registro' => 1,
                'password' => 'admin123',
                'must_change_password' => true,
            ]
        );

        $usuario2 = User::updateOrCreate(
            [
                'username' => 'admin2',
            ],
            [
                'persona_id' => $persona2->id,
                'rol_id' => 1,
                'estado_registro' => 1,
                'password' => 'admin123',
                'must_change_password' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Locales
        |--------------------------------------------------------------------------
        */

        $locales = Local::where('estado', true)
            ->pluck('id');

        foreach ($locales as $localId) {

            $usuario1->locales()->syncWithoutDetaching([
                $localId => [
                    'estado' => true,
                ]
            ]);

            $usuario2->locales()->syncWithoutDetaching([
                $localId => [
                    'estado' => true,
                ]
            ]);
        }
    }
}
