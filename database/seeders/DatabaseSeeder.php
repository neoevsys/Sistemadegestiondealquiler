<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UbigeoSeeder::class,
            TiposUsuarioSeeder::class,
            EstadosUsuarioSeeder::class,
            EstadosPropietarioSeeder::class,
            EstadosCentroSeeder::class,
            EstadosInstalacionSeeder::class,
            EstadosHorarioSeeder::class,
            EstadosReservaSeeder::class,
            MetodosPagoSeeder::class,
            EstadosPagoSeeder::class,
            TiposDocumentoSeeder::class,
            UsuariosSeeder::class,
            DemoSeeder::class, // Seeder de datos de prueba completos (usuarios, propietarios, centros, instalaciones, deportes)
            // Agrega aquí otros seeders de datos de prueba si los tienes (DemoSeeder, etc)
        ]);
    }
}
