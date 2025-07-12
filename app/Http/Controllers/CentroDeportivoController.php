<?php

namespace App\Http\Controllers;

use App\Models\CentroDeportivo;
use App\Models\Propietario;
use App\Models\TipoDeporte;
use App\Models\Departamento;
use App\Models\Provincia;
use App\Models\Distrito;
use App\Models\EstadoCentro;
use App\Http\Requests\CentroDeportivoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class CentroDeportivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener los tipos de deportes, ya que pueden ser necesarios en ambas vistas (pública y de propietario)
        $tiposDeportes = TipoDeporte::orderBy('nombre')->get();

        // Si es la ruta privada del propietario
        if ($request->routeIs('propietario.centros.index')) {
            $user = Auth::user();
            $propietario = $user->propietario; // Obtiene la relación con el modelo Propietario

            if ($propietario) {
                // Si hay un propietario, paginar sus centros
                $centros = $propietario->centrosDeportivos()->with(['instalaciones', 'departamento', 'provincia', 'distrito', 'estadoCentro'])->paginate(12);
            } else {
                // Si no hay propietario, retornar un paginador vacío
                $centros = new LengthAwarePaginator(
                    [], // No hay ítems
                    0,  // Total de ítems
                    12, // Ítems por página (puedes ajustar este valor si lo usas en la vista)
                    1,  // Página actual
                    ['path' => $request->url(), 'query' => $request->query()] // Reconstruir la URL para los enlaces de paginación
                );
            }
            // Pasar $tiposDeportes a la vista del propietario
            return view('propietario.centros.index', compact('centros', 'tiposDeportes'));
        }

        // Obtener departamentos, provincias y distritos para selects dependientes (para la parte pública)
        $departamentos = Departamento::orderBy('nombre')->get();
        $provincias = Provincia::orderBy('nombre')->get();
        $distritos = Distrito::orderBy('nombre')->get();
        // $tiposDeportes ya se obtuvo al inicio del método

        // Query base (para la parte pública)
        $query = CentroDeportivo::query();

        // Filtro por distrito (ciudad)
        if ($request->filled('distrito_id')) {
            $query->where('distrito_id', $request->distrito_id);
        }

        // Filtro por deporte
        if ($request->filled('tipo_deporte_id')) {
            $tipoDeporteId = $request->tipo_deporte_id;
            $query->whereHas('instalaciones.tiposDeporte', function ($q) use ($tipoDeporteId) {
                $q->where('tipos_deportes.id', $tipoDeporteId);
            });
        }

        $centros = $query->with(['departamento', 'provincia', 'distrito', 'estadoCentro'])->paginate(10); // Paginación para la parte pública

        return view('home', compact('centros', 'departamentos', 'provincias', 'distritos', 'tiposDeportes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departamentos = Departamento::orderBy('nombre')->get();
        $provincias = collect(); // Vacío inicialmente, se llenará con JS
        $distritos = collect();  // Vacío inicialmente, se llenará con JS
        $estadosCentro = EstadoCentro::all(); // Obtener todos los estados de centro

        return view('propietario.centros.create', compact('departamentos', 'provincias', 'distritos', 'estadosCentro'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CentroDeportivoRequest $request)
    {
        // Obtener el propietario autenticado
        $user = Auth::user();
        $propietario = $user->propietario;

        // Si no existe el registro de propietario, crearlo automáticamente (esto es para asegurar la existencia)
        // Opcional: Podrías redirigir o mostrar un error si el propietario no existe
        if (!$propietario) {
            // Esto solo se ejecutaría si el usuario tiene tipo_usuario='propietario' pero no hay registro en la tabla 'propietarios'
            // Podrías considerar un flujo donde el propietario completa su perfil antes de crear centros.
            $propietario = Propietario::create([
                'id' => Auth::user()->id, // Asegura que el ID de propietario sea el mismo que el ID de usuario
                'estado_id' => 1, // Asume un estado inicial 'aprobado' (o 'pendiente' si lo gestionas)
                // Otros campos obligatorios para Propietario si los hay
                'nombre_negocio' => $request->nombre, // Usar el nombre del centro como nombre de negocio por defecto
                'email_negocio' => $request->email,
                'telefono_negocio' => $request->telefono,
                'direccion_negocio' => $request->direccion,
            ]);
            // Una vez creado el propietario, recargar la relación en el usuario para que esté disponible
            $user->load('propietario');
        }

        $fotos = [];
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('centros_deportivos_fotos', 'public');
                $fotos[] = $path;
            }
        }

        $centro = CentroDeportivo::create([
            'propietario_id' => $propietario->id, // Usa el ID del propietario
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'direccion' => $request->direccion,
            'departamento_id' => $request->departamento_id,
            'provincia_id' => $request->provincia_id,
            'distrito_id' => $request->distrito_id,
            'codigo_postal' => $request->codigo_postal,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'servicios_adicionales' => $request->servicios_adicionales,
            'politicas' => $request->politicas,
            'estado_id' => $request->estado_id,
            'fecha_registro' => now(),
            'fotos' => $fotos,
        ]);

        return redirect()->route('propietario.centros.show', $centro)
            ->with('success', 'Centro deportivo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CentroDeportivo $centro)
    {
        // Carga las relaciones para mostrar detalles
        $centro->load(['propietario', 'departamento', 'provincia', 'distrito', 'estadoCentro', 'instalaciones']);
        return view('propietario.centros.show', compact('centro'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CentroDeportivo $centro)
    {
        // Autorizar la acción de edición
        $this->authorize('update', $centro);

        $departamentos = Departamento::orderBy('nombre')->get();
        // Cargar provincias y distritos del centro existente para los selects
        $provincias = Provincia::where('departamento_id', $centro->departamento_id)->orderBy('nombre')->get();
        $distritos = Distrito::where('provincia_id', $centro->provincia_id)->orderBy('nombre')->get();
        $estadosCentro = EstadoCentro::all();

        return view('propietario.centros.edit', compact('centro', 'departamentos', 'provincias', 'distritos', 'estadosCentro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CentroDeportivoRequest $request, CentroDeportivo $centro)
    {
        // Autorizar la acción de actualización
        $this->authorize('update', $centro);

        $fotos = $centro->fotos ?? []; // Mantener las fotos existentes

        // Eliminar fotos si se han marcado para eliminación (ej. a través de un campo oculto)
        // if ($request->has('fotos_a_eliminar')) {
        //     foreach ($request->fotos_a_eliminar as $fotoPath) {
        //         Storage::disk('public')->delete($fotoPath);
        //         $fotos = array_diff($fotos, [$fotoPath]);
        //     }
        // }

        // Añadir nuevas fotos
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $path = $foto->store('centros_deportivos_fotos', 'public');
                $fotos[] = $path;
            }
        }

        $centro->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'direccion' => $request->direccion,
            'departamento_id' => $request->departamento_id,
            'provincia_id' => $request->provincia_id,
            'distrito_id' => $request->distrito_id,
            'codigo_postal' => $request->codigo_postal,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'latitud' => $request->latitud,
            'longitud' => $request->longitud,
            'servicios_adicionales' => $request->servicios_adicionales,
            'politicas' => $request->politicas,
            'estado_id' => $request->estado_id,
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

        // Asume que 'activo'/'inactivo'/'mantenimiento' son los nombres de estado
        // Deberías usar los IDs de los estados para mayor robustez
        // Por ejemplo, buscar el ID del estado 'activo' y 'inactivo'
        $estadoActivoId = EstadoCentro::where('nombre', 'activo')->first()->id ?? null;
        $estadoInactivoId = EstadoCentro::where('nombre', 'inactivo')->first()->id ?? null;

        if ($centro->estado_id == $estadoActivoId) {
            $centro->update(['estado_id' => $estadoInactivoId]);
            $nuevoEstadoNombre = 'inactivo';
        } else {
            $centro->update(['estado_id' => $estadoActivoId]);
            $nuevoEstadoNombre = 'activo';
        }

        return back()->with('success', 'Estado del centro actualizado a: ' . ucfirst($nuevoEstadoNombre));
    }
}
