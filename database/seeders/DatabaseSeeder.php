<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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
            FaqSeeder::class, // Seeder de preguntas frecuentes
            DemoSeeder::class, // Seeder de datos de prueba completos (usuarios, propietarios, centros, instalaciones, deportes)
            // Agrega aquí otros seeders de datos de prueba si los tienes (DemoSeeder, etc)
        ]);
    }
}
