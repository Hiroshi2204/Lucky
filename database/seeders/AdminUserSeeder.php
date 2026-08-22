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

        $persona = Persona::updateOrCreate(
            [
                'numero_documento' => '00000000',
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
        | Usuario
        |--------------------------------------------------------------------------
        */

        $usuario = User::updateOrCreate(
            [
                'username' => 'admin',
            ],
            [
                'persona_id' => $persona->id,
                'rol_id' => 1,
                'estado_registro' => 'A',
                'password' => 'admin123',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Locales
        |--------------------------------------------------------------------------
        */

        $locales = Local::where('estado', true)
            ->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | Asignar administrador a todos los locales
        |--------------------------------------------------------------------------
        */

        foreach ($locales as $localId) {

            $usuario->locales()->syncWithoutDetaching([
                $localId => [
                    'estado' => true,
                ]
            ]);

        }
    }
}