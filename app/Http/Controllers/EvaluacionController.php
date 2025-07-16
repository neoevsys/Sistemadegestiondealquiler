<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluacionController extends Controller
{
    /**
     * Show the form for creating a new evaluation.
     */
    public function create(Reserva $reserva)
    {
        // Verificar que el usuario es propietario de la reserva
        if ($reserva->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para evaluar esta reserva.');
        }

        // Verificar que la reserva está completada
        if ($reserva->estado_id !== 4) {
            return redirect()->back()->with('error', 'Solo puedes evaluar reservas completadas.');
        }

        // Verificar que no existe una evaluación previa
        $evaluacionExistente = Evaluacion::where('reserva_id', $reserva->id)->first();
        if ($evaluacionExistente) {
            return redirect()->back()->with('error', 'Ya has evaluado esta reserva.');
        }

        return view('evaluaciones.create', compact('reserva'));
    }

    /**
     * Store a newly created evaluation in storage.
     */
    public function store(Request $request, Reserva $reserva)
    {
        // Verificar que el usuario es propietario de la reserva
        if ($reserva->usuario_id !== Auth::id()) {
            abort(403, 'No tienes permiso para evaluar esta reserva.');
        }

        // Verificar que la reserva está completada
        if ($reserva->estado_id !== 4) {
            return redirect()->back()->with('error', 'Solo puedes evaluar reservas completadas.');
        }

        // Verificar que no existe una evaluación previa
        $evaluacionExistente = Evaluacion::where('reserva_id', $reserva->id)->first();
        if ($evaluacionExistente) {
            return redirect()->back()->with('error', 'Ya has evaluado esta reserva.');
        }

        $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);

        Evaluacion::create([
            'reserva_id' => $reserva->id,
            'usuario_id' => Auth::id(),
            'centro_id' => $reserva->instalacion->centro_id,
            'instalacion_id' => $reserva->instalacion_id,
            'calificacion' => $request->calificacion,
            'comentario' => $request->comentario,
            'fecha_creacion' => now(),
        ]);

        return redirect()->route('reservas.index')
            ->with('success', 'Evaluación enviada exitosamente. ¡Gracias por tu opinión!');
    }

    /**
     * Display the specified evaluation.
     */
    public function show(Evaluacion $evaluacion)
    {
        return view('evaluaciones.show', compact('evaluacion'));
    }
}
