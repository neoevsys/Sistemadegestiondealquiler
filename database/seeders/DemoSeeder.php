<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Propietario;
use App\Models\TipoDeporte;
use App\Models\CentroDeportivo;
use App\Models\Instalacion;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Limpieza previa de datos demo (delete para evitar problemas de claves foráneas)
        DB::table('horarios_disponibilidad')->delete();
        DB::table('instalacion_tipo_deporte')->delete();
        \App\Models\Instalacion::query()->delete();
        \App\Models\CentroDeportivo::query()->delete();

        $placeholderFoto = 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80';
        // Tipos de deportes
        $deportes = [
            ['nombre' => 'Fútbol', 'descripcion' => 'Deporte de equipo', 'equipamiento_requerido' => 'Balón, arcos', 'icono_imagen' => 'https://cdn.pixabay.com/photo/2016/11/29/05/08/ball-1867077_1280.jpg'],
            ['nombre' => 'Vóley', 'descripcion' => 'Deporte de equipo ', 'equipamiento_requerido' => 'Balón, red', 'icono_imagen' => 'https://cdn.pixabay.com/photo/2017/08/10/07/32/volleyball-2619957_1280.jpg'],
            ['nombre' => 'Básquet', 'descripcion' => 'Deporte de equipo', 'equipamiento_requerido' => 'Balón, aros', 'icono_imagen' => 'https://cdn.pixabay.com/photo/2016/11/29/04/17/basketball-1868052_1280.jpg'],
            ['nombre' => 'Atletismo', 'descripcion' => 'Carreras, saltos y lanzamientos', 'equipamiento_requerido' => 'Zapatillas, pista', 'icono_imagen' => 'https://cdn.pixabay.com/photo/2016/11/29/09/32/athletics-1867162_1280.jpg'],
            ['nombre' => 'Natación', 'descripcion' => 'Deporte acuático', 'equipamiento_requerido' => 'Gorro, gafas', 'icono_imagen' => 'https://cdn.pixabay.com/photo/2016/11/29/09/32/swimming-1867161_1280.jpg'],
            ['nombre' => 'Tenis', 'descripcion' => 'Deporte de raqueta', 'equipamiento_requerido' => 'Raquetas, pelotas', 'icono_imagen' => 'https://cdn.pixabay.com/photo/2016/11/29/09/32/tennis-1867160_1280.jpg'],
            ['nombre' => 'Padel', 'descripcion' => 'Deporte de raqueta', 'equipamiento_requerido' => 'Palas, pelotas', 'icono_imagen' => 'https://cdn.pixabay.com/photo/2017/08/10/07/32/padel-2619958_1280.jpg'],
            ['nombre' => 'Ciclismo', 'descripcion' => 'Deporte individual y de equipo', 'equipamiento_requerido' => 'Bicicleta, casco', 'icono_imagen' => 'https://cdn.pixabay.com/photo/2016/11/29/09/32/cycling-1867159_1280.jpg'],
            ['nombre' => 'Boxeo', 'descripcion' => 'Deporte de combate', 'equipamiento_requerido' => 'Guantes, vendas', 'icono_imagen' => 'https://cdn.pixabay.com/photo/2016/11/29/09/32/boxing-1867158_1280.jpg'],
            ['nombre' => 'Surf', 'descripcion' => 'Deporte acuático muy practicado en la costa peruana', 'equipamiento_requerido' => 'Tabla de surf', 'icono_imagen' => 'https://cdn.pixabay.com/photo/2016/11/29/09/32/surfing-1867157_1280.jpg'],
            ['nombre' => 'Running', 'descripcion' => 'Deporte individual', 'equipamiento_requerido' => 'Zapatillas', 'icono_imagen' => 'https://cdn.pixabay.com/photo/2016/11/29/09/32/running-1867156_1280.jpg'],
            ['nombre' => 'Karate', 'descripcion' => 'Arte marcial', 'equipamiento_requerido' => 'Kimono, cinturón', 'icono_imagen' => 'https://cdn.pixabay.com/photo/2017/08/10/07/32/karate-2619956_1280.jpg'],
            ['nombre' => 'Taekwondo', 'descripcion' => 'Arte marcial', 'equipamiento_requerido' => 'Dobok, cinturón', 'icono_imagen' => 'https://cdn.pixabay.com/photo/2017/08/10/07/32/taekwondo-2619955_1280.jpg'],
            ['nombre' => 'Yoga', 'descripcion' => 'Disciplina física y mental', 'equipamiento_requerido' => 'Mat', 'icono_imagen' => 'https://cdn.pixabay.com/photo/2016/11/29/09/32/yoga-1867154_1280.jpg'],
            ['nombre' => 'Crossfit', 'descripcion' => 'Entrenamiento funcional', 'equipamiento_requerido' => 'Pesas, cuerda', 'icono_imagen' => 'https://cdn.pixabay.com/photo/2017/08/10/07/32/crossfit-2619953_1280.jpg'],
        ];
        foreach ($deportes as $d) {
            if (!TipoDeporte::where('nombre', $d['nombre'])->exists()) {
                TipoDeporte::create($d);
            }
        }

        // Usar propietarios ya existentes (creados en UsuariosSeeder)
        $propietarios = \App\Models\Propietario::all();
        foreach ($propietarios as $p) {
            for ($j = 1; $j <= 2; $j++) {
                $nombreCentro = 'Centro '.$p->id.'-'.$j;
                // Evitar duplicados: buscar por nombre y propietario
                $centro = CentroDeportivo::where('nombre', $nombreCentro)
                    ->where('propietario_id', $p->id)
                    ->first();
                if (!$centro) {
                    $fotosCentro = [
                        'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80',
                        'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=600&q=80',
                        'https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=600&q=80'
                    ];
                    $fotosCentro = array_filter($fotosCentro, fn($f) => !empty($f) && is_string($f));
                    if (empty($fotosCentro)) {
                        $fotosCentro = [$placeholderFoto];
                    }
                    $centro = CentroDeportivo::create([
                        'propietario_id' => $p->id,
                        'nombre' => $nombreCentro,
                        'descripcion' => 'Centro deportivo demo',
                        'direccion' => 'Av. Principal '.$j.', Ciudad',
                        'departamento_id' => '01',
                        'provincia_id' => '0101',
                        'distrito_id' => '010101',
                        'codigo_postal' => '1000'.$j,
                        'telefono' => '90000000'.$j,
                        'email' => 'centro'.$p->id.'_'.$j.'@mail.com',
                        'latitud' => -12.0 + $j*0.01,
                        'longitud' => -77.0 + $j*0.01,
                        'servicios_adicionales' => 'Estacionamiento, WiFi',
                        'politicas' => 'No fumar',
                        'calificacion_promedio' => rand(3,5),
                        'estado_id' => 1,
                        'fecha_registro' => now(),
                        'fotos' => $fotosCentro,
                    ]);
                } else {
                    // Si ya existe, asegurarse de tener el objeto correcto
                    $centro = CentroDeportivo::where('nombre', $nombreCentro)
                        ->where('propietario_id', $p->id)
                        ->first();
                }
                // Instalaciones para cada centro
                if ($centro && !empty($centro->id)) {
                    for ($k = 1; $k <= 3; $k++) {
                        $nombreInstalacion = 'Instalación '.$centro->id.'-'.$k;
                        $instalacion = Instalacion::where('nombre', $nombreInstalacion)
                            ->where('centro_id', $centro->id)
                            ->first();
                        if (!$instalacion) {
                            $fotosInstalacion = [
                                'https://images.unsplash.com/photo-1517649763962-0c623066013b?auto=format&fit=crop&w=600&q=80',
                                'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=600&q=80',
                                'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=600&q=80'
                            ];
                            $fotosInstalacion = array_filter($fotosInstalacion, fn($f) => !empty($f) && is_string($f));
                            if (empty($fotosInstalacion)) {
                                $fotosInstalacion = [$placeholderFoto];
                            }
                            
                            // Datos variados para instalaciones
                            $tiposInstalacion = [
                                ['superficie' => 'Césped sintético', 'dimensiones' => '40x20', 'equipamiento' => 'Arcos, balones'],
                                ['superficie' => 'Parquet', 'dimensiones' => '28x15', 'equipamiento' => 'Canastas, balones'],
                                ['superficie' => 'Cemento', 'dimensiones' => '20x10', 'equipamiento' => 'Red, pelotas']
                            ];
                            
                            $tipoActual = $tiposInstalacion[($k-1) % 3];
                            
                            $instalacion = Instalacion::create([
                                'centro_id' => $centro->id,
                                'nombre' => $nombreInstalacion,
                                'descripcion' => 'Instalación deportiva equipada para la práctica de deportes',
                                'capacidad_maxima' => 8 + ($k * 2),
                                'precio_por_hora' => 25 + ($k * 15),
                                'superficie' => $tipoActual['superficie'],
                                'dimensiones' => $tipoActual['dimensiones'],
                                'equipamiento_incluido' => $tipoActual['equipamiento'],
                                'estado_id' => 1,
                                'fotos' => $fotosInstalacion,
                            ]);
                            
                            // Asociar múltiples deportes a cada instalación
                            $deportesIds = [];
                            switch($k) {
                                case 1:
                                    $deportesIds = [1, 2]; // Fútbol, Vóley
                                    break;
                                case 2:
                                    $deportesIds = [3, 4]; // Básquet, Atletismo
                                    break;
                                case 3:
                                    $deportesIds = [6, 7]; // Tenis, Padel
                                    break;
                            }
                            
                            foreach($deportesIds as $deporteId) {
                                DB::table('instalacion_tipo_deporte')->insert([
                                    'instalacion_id' => $instalacion->id,
                                    'tipo_deporte_id' => $deporteId
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }
}
