<?php

namespace App\Http\Controllers;

use App\Models\Instalacion;
use App\Models\TipoDeporte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InstalacionController extends Controller
{
    public function index(Request $request, \App\Models\CentroDeportivo $centro = null)
    {
        // Si se proporciona un centro, mostrar las instalaciones de ese centro
        if ($centro) {
            $this->authorize('view', $centro);

            $instalaciones = $centro->instalaciones()
                ->with(['tiposDeporte', 'estadoInstalacion', 'reservas'])
                ->paginate(12);

            return view('propietario.centros.instalaciones.index', compact('centro', 'instalaciones'));
        }

        // Si no se proporciona centro, mostrar todas las instalaciones (vista pública)
        $query = Instalacion::with(['centroDeportivo.departamento', 'centroDeportivo.provincia', 'centroDeportivo.distrito', 'tiposDeporte'])
            ->whereHas('centroDeportivo', function($q) {
                $q->where('estado_id', 1); // Solo centros activos
            });

        // Filtros
        if ($request->filled('departamento_id')) {
            $query->whereHas('centroDeportivo', function($q) use ($request) {
                $q->where('departamento_id', $request->departamento_id);
            });
        }

        if ($request->filled('provincia_id')) {
            $query->whereHas('centroDeportivo', function($q) use ($request) {
                $q->where('provincia_id', $request->provincia_id);
            });
        }

        if ($request->filled('distrito_id')) {
            $query->whereHas('centroDeportivo', function($q) use ($request) {
                $q->where('distrito_id', $request->distrito_id);
            });
        }

        if ($request->filled('deporte')) {
            $query->whereHas('tiposDeporte', function($q) use ($request) {
                $q->where('nombre', $request->deporte);
            });
        }

        if ($request->filled('precio')) {
            switch ($request->precio) {
                case '1':
                    $query->where('precio_por_hora', '<', 20);
                    break;
                case '2':
                    $query->whereBetween('precio_por_hora', [20, 40]);
                    break;
                case '3':
                    $query->where('precio_por_hora', '>', 40);
                    break;
            }
        }

        if ($request->filled('superficie')) {
            $query->where('superficie', $request->superficie);
        }

        if ($request->filled('capacidad')) {
            switch ($request->capacidad) {
                case '1':
                    $query->where('capacidad_maxima', '<=', 10);
                    break;
                case '2':
                    $query->whereBetween('capacidad_maxima', [11, 20]);
                    break;
                case '3':
                    $query->where('capacidad_maxima', '>', 20);
                    break;
            }
        }

        $instalaciones = $query->orderBy('created_at', 'desc')->paginate(12);

        // Obtener datos para filtros
        $departamentos = DB::table('departamentos')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('centros_deportivos')
                    ->whereRaw('centros_deportivos.departamento_id = departamentos.id')
                    ->where('estado_id', 1);
            })
            ->orderBy('nombre')
            ->get();

        $provincias = DB::table('provincias')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('centros_deportivos')
                    ->whereRaw('centros_deportivos.provincia_id = provincias.id')
                    ->where('estado_id', 1);
            })
            ->orderBy('nombre')
            ->get();

        $distritos = DB::table('distritos')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('centros_deportivos')
                    ->whereRaw('centros_deportivos.distrito_id = distritos.id')
                    ->where('estado_id', 1);
            })
            ->orderBy('nombre')
            ->get();

        $tiposDeportes = TipoDeporte::orderBy('nombre')->get();

        $superficies = Instalacion::whereHas('centroDeportivo', function($q) {
                $q->where('estado_id', 1);
            })
            ->distinct()
            ->pluck('superficie')
            ->filter()
            ->sort();

        return view('instalaciones.index', compact('instalaciones', 'departamentos', 'provincias', 'distritos', 'tiposDeportes', 'superficies'));
    }


    /**
     * Show the form for creating a new installation.
     */
    public function create(\App\Models\CentroDeportivo $centro)
    {
        $this->authorize('update', $centro);

        $tiposDeporte = TipoDeporte::orderBy('nombre')->get();
        $estadosInstalacion = \App\Models\EstadoInstalacion::all();
        $superficies = ['Césped natural', 'Césped sintético', 'Concreto', 'Madera', 'Arena', 'Tierra', 'Otro'];

        return view('propietario.centros.instalaciones.create', compact('centro', 'tiposDeporte', 'estadosInstalacion', 'superficies'));
    }

    /**
     * Store a newly created installation.
     */
    public function store(Request $request, \App\Models\CentroDeportivo $centro)
    {
        $this->authorize('update', $centro);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipos_deporte' => 'required|array|min:1',
            'tipos_deporte.*' => 'exists:tipos_deportes,id',
            'precio_por_hora' => 'required|numeric|min:0',
            'capacidad_maxima' => 'required|integer|min:1',
            'superficie' => 'required|string',
            'dimensiones' => 'nullable|string',
            'estado_id' => 'required|exists:estados_instalacion,id',
            'foto_principal' => 'nullable|image|max:5120',
            'fotos_adicionales.*' => 'nullable|image|max:5120',
        ]);

        $fotoPrincipal = null;
        if ($request->hasFile('foto_principal')) {
            $fotoPrincipal = $request->file('foto_principal')->store('instalaciones_fotos', 'public');
        }

        $fotosAdicionales = [];
        if ($request->hasFile('fotos_adicionales')) {
            foreach ($request->file('fotos_adicionales') as $foto) {
                $fotosAdicionales[] = $foto->store('instalaciones_fotos', 'public');
            }
        }

        $instalacion = $centro->instalaciones()->create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_por_hora' => $request->precio_por_hora,
            'capacidad_maxima' => $request->capacidad_maxima,
            'superficie' => $request->superficie,
            'dimensiones' => $request->dimensiones,
            'estado_id' => $request->estado_id,
            'foto_principal' => $fotoPrincipal,
            'fotos_adicionales' => $fotosAdicionales,
            'fecha_creacion' => now(),
        ]);

        // Asociar tipos de deporte
        $instalacion->tiposDeporte()->attach($request->tipos_deporte);

        return redirect()->route('propietario.centros.instalaciones.index', $centro)
            ->with('success', 'Instalación creada exitosamente.');
    }

    /**
     * Display the specified installation.
     */
    public function show(\App\Models\CentroDeportivo $centro, Instalacion $instalacion)
    {
        $this->authorize('view', $centro);

        // Verificar que la instalación pertenece al centro
        if ($instalacion->centro_id !== $centro->id) {
            abort(404);
        }

        $instalacion->load(['tiposDeporte', 'estadoInstalacion', 'reservas.usuario']);

        return view('propietario.centros.instalaciones.show', compact('centro', 'instalacion'));
    }

    /**
     * Show the form for editing the specified installation.
     */
    public function edit(\App\Models\CentroDeportivo $centro, Instalacion $instalacion)
    {
        $this->authorize('update', $centro);

        // Verificar que la instalación pertenece al centro
        if ($instalacion->centro_id !== $centro->id) {
            abort(404);
        }

        $tiposDeporte = TipoDeporte::orderBy('nombre')->get();
        $estadosInstalacion = \App\Models\EstadoInstalacion::all();
        $superficies = ['Césped natural', 'Césped sintético', 'Concreto', 'Madera', 'Arena', 'Tierra', 'Otro'];

        return view('propietario.centros.instalaciones.edit', compact('centro', 'instalacion', 'tiposDeporte', 'estadosInstalacion', 'superficies'));
    }

    /**
     * Update the specified installation.
     */
    public function update(Request $request, \App\Models\CentroDeportivo $centro, Instalacion $instalacion)
    {
        $this->authorize('update', $centro);

        // Verificar que la instalación pertenece al centro
        if ($instalacion->centro_id !== $centro->id) {
            abort(404);
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'tipos_deporte' => 'required|array|min:1',
            'tipos_deporte.*' => 'exists:tipos_deportes,id',
            'precio_por_hora' => 'required|numeric|min:0',
            'capacidad_maxima' => 'required|integer|min:1',
            'superficie' => 'required|string',
            'dimensiones' => 'nullable|string',
            'estado_id' => 'required|exists:estados_instalacion,id',
            'foto_principal' => 'nullable|image|max:5120',
            'fotos_adicionales.*' => 'nullable|image|max:5120',
        ]);

        $data = $request->except(['foto_principal', 'fotos_adicionales', 'tipos_deporte']);

        // Manejar foto principal
        if ($request->hasFile('foto_principal')) {
            if ($instalacion->foto_principal) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($instalacion->foto_principal);
            }
            $data['foto_principal'] = $request->file('foto_principal')->store('instalaciones_fotos', 'public');
        }

        // Manejar fotos adicionales
        $fotosAdicionales = $instalacion->fotos_adicionales ?? [];
        if ($request->hasFile('fotos_adicionales')) {
            foreach ($request->file('fotos_adicionales') as $foto) {
                $fotosAdicionales[] = $foto->store('instalaciones_fotos', 'public');
            }
            $data['fotos_adicionales'] = $fotosAdicionales;
        }

        $instalacion->update($data);

        // Actualizar tipos de deporte
        $instalacion->tiposDeporte()->sync($request->tipos_deporte);

        return redirect()->route('propietario.centros.instalaciones.show', [$centro, $instalacion])
            ->with('success', 'Instalación actualizada exitosamente.');
    }

    /**
     * Remove the specified installation.
     */
    public function destroy(\App\Models\CentroDeportivo $centro, Instalacion $instalacion)
    {
        $this->authorize('update', $centro);

        // Verificar que la instalación pertenece al centro
        if ($instalacion->centro_id !== $centro->id) {
            abort(404);
        }

        // Eliminar fotos del almacenamiento
        if ($instalacion->foto_principal) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($instalacion->foto_principal);
        }
        if ($instalacion->fotos_adicionales) {
            foreach ($instalacion->fotos_adicionales as $foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($foto);
            }
        }

        $instalacion->delete();

        return redirect()->route('propietario.centros.instalaciones.index', $centro)
            ->with('success', 'Instalación eliminada exitosamente.');
    }
}
