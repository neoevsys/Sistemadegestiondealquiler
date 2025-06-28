<?php

namespace App\Http\Controllers;

use App\Models\CentroDeportivo;
use App\Models\Propietario;
use App\Models\TipoDeporte;
use App\Http\Requests\CentroDeportivoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CentroDeportivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Si es la ruta privada del propietario
        if ($request->routeIs('propietario.centros.index')) {
            $user = Auth::user();
            $propietario = $user->propietario;
            $centros = $propietario ? $propietario->centrosDeportivos()->with('instalaciones')->paginate(12) : collect();
            return view('propietario.centros.index', compact('centros'));
        }

        // Obtener ciudades únicas de la base de datos
        $ciudades = CentroDeportivo::select('ciudad')->distinct()->orderBy('ciudad')->pluck('ciudad');
        // Obtener deportes únicos de la base de datos
        $tiposDeportes = \App\Models\TipoDeporte::orderBy('nombre')->get();

        // Query base
        $query = CentroDeportivo::query();

        // Filtro por ciudad
        if ($request->filled('ciudad')) {
            $query->where('ciudad', $request->ciudad);
        }
        // Filtro por deporte (al menos una instalación de ese deporte)
        if ($request->filled('deporte')) {
            $query->whereHas('instalaciones.tipoDeporte', function($q) use ($request) {
                $q->where('nombre', $request->deporte);
            });
        }
        // Filtro por fecha (opcional, aquí solo como placeholder, lógica real depende de reservas y disponibilidad)
        if ($request->filled('fecha')) {
            // Aquí podrías filtrar centros con instalaciones disponibles en esa fecha
            // Ejemplo: $query->whereHas('instalaciones.horariosDisponibilidad', ...)
        }
        // Filtro por rango de precio (en instalaciones)
        if ($request->filled('precio')) {
            $query->whereHas('instalaciones', function($q) use ($request) {
                if ($request->precio == '1') {
                    $q->where('precio_por_hora', '<', 20);
                } elseif ($request->precio == '2') {
                    $q->whereBetween('precio_por_hora', [20, 40]);
                } elseif ($request->precio == '3') {
                    $q->where('precio_por_hora', '>', 40);
                }
            });
        }
        // Filtro por valoración
        if ($request->filled('valoracion')) {
            $query->where('calificacion_promedio', '>=', floatval($request->valoracion));
        }

        // Cargar centros paginados
        $centros = $query->orderBy('created_at', 'desc')->paginate(12)->withQueryString();

        // Si la ruta es /centros, mostrar la vista de centros, si es /, mostrar welcome
        if ($request->routeIs('centros.index')) {
            return view('centros.index', compact('centros', 'ciudades', 'tiposDeportes'));
        }
        return view('welcome', [
            'ciudades' => $ciudades,
            'deportes' => $tiposDeportes->pluck('nombre'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('propietario.centros.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CentroDeportivoRequest $request)
    {
        $propietario = Auth::user()->propietario;

        // Si no existe el registro de propietario, crearlo automáticamente
        if (!$propietario) {
            $propietario = Propietario::create([
                'id_propietario' => Auth::user()->id_usuario,
                'estado' => 'aprobado'
            ]);
        }

        // Manejar la subida de fotos
        $fotos = [];
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('centros/' . $propietario->id_propietario, 'public');
                $fotos[] = $path;
            }
        }

        $centro = CentroDeportivo::create([
            'id_propietario' => $propietario->id_propietario,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'direccion' => $request->direccion,
            'ciudad' => $request->ciudad,
            'distrito' => $request->distrito,
            'codigo_postal' => $request->codigo_postal,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'servicios_adicionales' => $request->servicios_adicionales,
            'politicas' => $request->politicas,
            'estado' => $request->estado ?? 'activo',
            'fotos' => $fotos,
        ]);

        return redirect()->route('propietario.centros.index')
            ->with('success', 'Centro deportivo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CentroDeportivo $centro)
    {
        $this->authorize('view', $centro);

        return view('propietario.centros.show', compact('centro'));
    }

    /**
     * Mostrar el detalle público de un centro deportivo.
     */
    public function showPublic($id)
    {
        $centro = \App\Models\CentroDeportivo::with(['instalaciones.tipoDeporte', 'evaluaciones'])->findOrFail($id);
        return view('centros.show', compact('centro'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CentroDeportivo $centro)
    {
        $this->authorize('update', $centro);

        return view('propietario.centros.edit', compact('centro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CentroDeportivoRequest $request, CentroDeportivo $centro)
    {
        $this->authorize('update', $centro);

        // Manejar la actualización de fotos
        $fotos = $centro->fotos ?? [];

        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('centros/' . $centro->id_propietario, 'public');
                $fotos[] = $path;
            }
        }

        // Eliminar fotos seleccionadas
        if ($request->has('fotos_eliminar')) {
            foreach ($request->fotos_eliminar as $fotoEliminar) {
                if (($key = array_search($fotoEliminar, $fotos)) !== false) {
                    unset($fotos[$key]);
                    Storage::disk('public')->delete($fotoEliminar);
                }
            }
            $fotos = array_values($fotos); // Reindexar array
        }

        $centro->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'direccion' => $request->direccion,
            'ciudad' => $request->ciudad,
            'distrito' => $request->distrito,
            'codigo_postal' => $request->codigo_postal,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'servicios_adicionales' => $request->servicios_adicionales,
            'politicas' => $request->politicas,
            'estado' => $request->estado,
            'fotos' => $fotos,
        ]);

        return redirect()->route('propietario.centros.show', $centro)
            ->with('success', 'Centro deportivo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CentroDeportivo $centro)
    {
        $this->authorize('delete', $centro);

        // Eliminar fotos del almacenamiento
        if ($centro->fotos) {
            foreach ($centro->fotos as $foto) {
                Storage::disk('public')->delete($foto);
            }
        }

        $centro->delete();

        return redirect()->route('propietario.centros.index')
            ->with('success', 'Centro deportivo eliminado exitosamente.');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(CentroDeportivo $centro)
    {
        $this->authorize('update', $centro);

        $nuevoEstado = $centro->estado === 'activo' ? 'inactivo' : 'activo';

        $centro->update(['estado' => $nuevoEstado]);

        return back()->with('success', 'Estado del centro actualizado a: ' . ucfirst($nuevoEstado));
    }
}
