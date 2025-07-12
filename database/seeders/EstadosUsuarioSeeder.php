<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosUsuarioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('estados_usuario')->insert([
            ['id' => 1, 'nombre' => 'activo'],
            ['id' => 2, 'nombre' => 'inactivo'],
            ['id' => 3, 'nombre' => 'suspendido'],
        ]);
    }
}
