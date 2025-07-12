<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosCentroSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('estados_centro')->insert([
            ['id' => 1, 'nombre' => 'activo'],
            ['id' => 2, 'nombre' => 'inactivo'],
            ['id' => 3, 'nombre' => 'mantenimiento'],
        ]);
    }
}
