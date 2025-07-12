<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosReservaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('estados_reserva')->insert([
            ['id' => 1, 'nombre' => 'pendiente'],
            ['id' => 2, 'nombre' => 'confirmada'],
            ['id' => 3, 'nombre' => 'completada'],
            ['id' => 4, 'nombre' => 'cancelada'],
        ]);
    }
}
