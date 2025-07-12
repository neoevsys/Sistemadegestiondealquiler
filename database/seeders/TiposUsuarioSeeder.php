<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposUsuarioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipos_usuario')->insert([
            ['id' => 1, 'nombre' => 'administrador'],
            ['id' => 2, 'nombre' => 'cliente'],
            ['id' => 3, 'nombre' => 'propietario'],
        ]);
    }
}
