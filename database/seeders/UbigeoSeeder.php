<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UbigeoSeeder extends Seeder
{
    public function run(): void
    {
        // Poblar departamentos desde CSV
        if (($handle = fopen(database_path('data/departamentos.csv'), 'r')) !== false) {
            fgetcsv($handle); // Saltar encabezado
            while (($data = fgetcsv($handle)) !== false) {
                DB::table('departamentos')->insert([
                    'id' => $data[0],
                    'nombre' => $data[1],
                ]);
            }
            fclose($handle);
        }
        // Poblar provincias desde CSV
        if (($handle = fopen(database_path('data/provincias.csv'), 'r')) !== false) {
            fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                DB::table('provincias')->insert([
                    'id' => $data[0],
                    'nombre' => $data[1],
                    'departamento_id' => $data[2],
                ]);
            }
            fclose($handle);
        }
        // Poblar distritos desde CSV
        if (($handle = fopen(database_path('data/distritos.csv'), 'r')) !== false) {
            fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                DB::table('distritos')->insert([
                    'id' => $data[0],
                    'nombre' => $data[1],
                    'provincia_id' => $data[2],
                ]);
            }
            fclose($handle);
        }
    }
}
