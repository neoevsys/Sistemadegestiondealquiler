<?php

namespace App\Http\Controllers;

use App\Models\CentroDeportivo;
use App\Http\Requests\CentroDeportivoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CentroDeportivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $propietario = Auth::user()->propietario;
        
        if (!$propietario) {
            return redirect()->route('propietario.dashboard')
                ->with('error', 'Debes completar tu perfil de propietario primero.');
        }

        $centros = CentroDeportivo::where('id_propietario', $propietario->id_propietario)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('propietario.centros.index', compact('centros'));
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
        
        if (!$propietario) {
            return redirect()->route('propietario.dashboard')
                ->with('error', 'Debes completar tu perfil de propietario primero.');
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
