<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetodosPagoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('metodos_pago')->insert([
            ['id' => 1, 'nombre' => 'efectivo'],
            ['id' => 2, 'nombre' => 'tarjeta'],
            ['id' => 3, 'nombre' => 'transferencia'],
            ['id' => 4, 'nombre' => 'yape'],
            ['id' => 5, 'nombre' => 'plin'],
        ]);
    }
}
