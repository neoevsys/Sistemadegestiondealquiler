<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosHorarioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('estados_horario')->insert([
            ['id' => 1, 'nombre' => 'disponible'],
            ['id' => 2, 'nombre' => 'ocupado'],
            ['id' => 3, 'nombre' => 'bloqueado'],
        ]);
    }
}
