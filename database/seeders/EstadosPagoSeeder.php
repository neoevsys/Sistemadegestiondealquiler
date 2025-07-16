<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosPagoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('estados_pago')->insert([
            ['id' => 1, 'nombre' => 'completado'],
            ['id' => 2, 'nombre' => 'pendiente'],
            ['id' => 3, 'nombre' => 'fallido'],
            ['id' => 4, 'nombre' => 'reembolsado'],
        ]);
    }
}
