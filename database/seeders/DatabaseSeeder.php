<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            DepartamentoSeeder::class,
            ProvinciaSeeder::class,
            DistritoSeeder::class,
            UserSeeder::class,
            TipoDocumentoSeeder::class,
            ProveedorSeeder::class,
            DestinatarioSeeder::class,
            MarcaSeeder::class,
            ColorSeeder::class,
            RolSeeder::class,
            EmpresaSeeder::class,
            AlmacenSeeder::class,
            TipoRolSeeder::class,
        ]);
    }
}