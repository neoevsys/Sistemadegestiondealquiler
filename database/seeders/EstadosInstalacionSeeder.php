<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosInstalacionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('estados_instalacion')->insert([
            ['id' => 1, 'nombre' => 'disponible'],
            ['id' => 2, 'nombre' => 'mantenimiento'],
            ['id' => 3, 'nombre' => 'fuera_servicio'],
        ]);
    }
}
