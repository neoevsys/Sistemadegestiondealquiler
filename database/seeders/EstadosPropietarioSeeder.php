<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosPropietarioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('estados_propietario')->insert([
            ['id' => 1, 'nombre' => 'pendiente'],
            ['id' => 2, 'nombre' => 'aprobado'],
            ['id' => 3, 'nombre' => 'rechazado'],
        ]);
    }
}
