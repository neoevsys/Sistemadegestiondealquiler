<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposDocumentoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipos_documento')->insertOrIgnore([
            ['nombre' => 'DNI', 'descripcion' => 'Documento Nacional de Identidad'],
            ['nombre' => 'RUC', 'descripcion' => 'Registro Único de Contribuyentes'],
            ['nombre' => 'CE', 'descripcion' => 'Carné de Extranjería'],
            ['nombre' => 'PASAPORTE', 'descripcion' => 'Pasaporte'],
        ]);
    }
}
