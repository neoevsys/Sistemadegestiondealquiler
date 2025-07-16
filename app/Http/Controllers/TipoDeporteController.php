<?php

namespace App\Http\Controllers;

use App\Models\TipoDeporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoDeporteController extends Controller
{
    public function index()
    {
        // Obtener tipos de deportes que tienen instalaciones disponibles
        $deportes = TipoDeporte::whereHas('instalaciones', function($query) {
            $query->whereHas('centroDeportivo', function($q) {
                $q->where('estado_id', 1); // Solo centros activos
            });
        })->withCount(['instalaciones' => function($query) {
            $query->whereHas('centroDeportivo', function($q) {
                $q->where('estado_id', 1);
            });
        }])->orderBy('nombre')->get();

        // Obtener información adicional sobre cada deporte
        $deportes->each(function($deporte) {
            // Obtener precio promedio
            $deporte->precio_promedio = $deporte->instalaciones()
                ->whereHas('centroDeportivo', function($q) {
                    $q->where('estado_id', 1);
                })
                ->avg('precio_por_hora');

            // Obtener precio mínimo y máximo
            $precios = $deporte->instalaciones()
                ->whereHas('centroDeportivo', function($q) {
                    $q->where('estado_id', 1);
                })
                ->pluck('precio_por_hora');

            $deporte->precio_min = $precios->min();
            $deporte->precio_max = $precios->max();

            // Obtener ubicaciones únicas
            $deporte->ubicaciones = $deporte->instalaciones()
                ->whereHas('centroDeportivo', function($q) {
                    $q->where('estado_id', 1);
                })
                ->with('centroDeportivo.distrito')
                ->get()
                ->pluck('centroDeportivo.distrito.nombre')
                ->unique()
                ->values();
        });

        return view('tipos_deportes.index', compact('deportes'));
    }
}
