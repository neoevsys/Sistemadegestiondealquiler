<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Instalacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservaController extends Controller
{
    /**
     * Display a listing of the user's reservations.
     */
    public function index()
    {
        $reservas = Reserva::where('usuario_id', Auth::id())
            ->with(['instalacion.centroDeportivo', 'instalacion.tiposDeporte'])
            ->orderBy('fecha_reserva', 'desc')
            ->paginate(10);
            
        return view('reservas.index', compact('reservas'));
    }

    /**
     * Show the form for creating a new reservation.
     */
    public function create(Request $request)
    {
        $instalacion = Instalacion::with(['centroDeportivo', 'tiposDeporte'])->findOrFail($request->instalacion_id);
        
        // Obtener horarios disponibles para hoy y los próximos 7 días
        $fechasDisponibles = [];
        for ($i = 0; $i < 7; $i++) {
            $fecha = Carbon::now()->addDays($i);
            $fechasDisponibles[$fecha->format('Y-m-d')] = $fecha->format('d/m/Y');
        }
        
        return view('reservas.create', compact('instalacion', 'fechasDisponibles'));
    }

    /**
     * Store a newly created reservation.
     */
    public function store(Request $request)
    {
        $request->validate([
            'instalacion_id' => 'required|exists:instalaciones,id',
            'fecha_reserva' => 'required|date|after_or_equal:today',
            'hora_inicio' => 'required|date_format:H:i',
            'duracion_horas' => 'required|integer|min:1|max:8',
        ]);

        $instalacion = Instalacion::findOrFail($request->instalacion_id);
        
        $fechaReserva = Carbon::parse($request->fecha_reserva);
        $horaInicio = Carbon::parse($request->fecha_reserva . ' ' . $request->hora_inicio);
        $horaFin = $horaInicio->copy()->addHours((int) $request->duracion_horas);
        
        // Verificar disponibilidad
        $conflictos = Reserva::where('instalacion_id', $instalacion->id)
            ->where('fecha_reserva', $fechaReserva->format('Y-m-d'))
            ->where(function($query) use ($horaInicio, $horaFin) {
                $query->whereBetween('hora_inicio', [$horaInicio->format('H:i'), $horaFin->format('H:i')])
                      ->orWhereBetween('hora_fin', [$horaInicio->format('H:i'), $horaFin->format('H:i')])
                      ->orWhere(function($q) use ($horaInicio, $horaFin) {
                          $q->where('hora_inicio', '<=', $horaInicio->format('H:i'))
                            ->where('hora_fin', '>=', $horaFin->format('H:i'));
                      });
            })
            ->exists();

        if ($conflictos) {
            return back()->withErrors(['hora_inicio' => 'El horario seleccionado no está disponible.']);
        }

        $precioTotal = $instalacion->precio_por_hora * $request->duracion_horas;

        $reserva = Reserva::create([
            'usuario_id' => Auth::id(),
            'instalacion_id' => $instalacion->id,
            'fecha_reserva' => $fechaReserva->format('Y-m-d'),
            'hora_inicio' => $horaInicio->format('H:i:s'),
            'hora_fin' => $horaFin->format('H:i:s'),
            'duracion_horas' => $request->duracion_horas,
            'precio_total' => $precioTotal,
            'estado_id' => 1, // Pendiente
            'fecha_creacion' => now(),
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('reservas.show', $reserva->id)
            ->with('success', 'Reserva creada exitosamente.');
    }

    /**
     * Display the specified reservation.
     */
    public function show($id)
    {
        $reserva = Reserva::with(['instalacion.centroDeportivo', 'instalacion.tiposDeporte', 'usuario', 'pago'])
            ->where('id', $id)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        return view('reservas.show', compact('reserva'));
    }

    /**
     * Cancel a reservation.
     */
    public function cancel($id)
    {
        $reserva = Reserva::where('id', $id)
            ->where('usuario_id', Auth::id())
            ->firstOrFail();

        // Solo se pueden cancelar reservas pendientes
        if ($reserva->estado_id !== 1) {
            $mensaje = match($reserva->estado_id) {
                2 => 'No puedes cancelar una reserva confirmada (ya pagada).',
                3 => 'La reserva ya está cancelada.',
                4 => 'No puedes cancelar una reserva completada.',
                default => 'No puedes cancelar esta reserva en su estado actual.'
            };
            
            return back()->with('error', $mensaje);
        }

        $reserva->update([
            'estado_id' => 3, // Cancelada
            'fecha_modificacion' => now(),
        ]);

        return redirect()->route('reservas.index')
            ->with('success', 'Reserva cancelada exitosamente.');
    }

    /**
     * Get available hours for a specific date and installation.
     */
    public function getAvailableHours(Request $request)
    {
        $instalacion = Instalacion::findOrFail($request->instalacion_id);
        $fecha = Carbon::parse($request->fecha);
        
        // Horarios base (6:00 AM a 10:00 PM)
        $horariosBase = [];
        for ($hora = 6; $hora <= 22; $hora++) {
            $horariosBase[] = sprintf('%02d:00', $hora);
        }
        
        // Obtener reservas existentes
        $reservasExistentes = Reserva::where('instalacion_id', $instalacion->id)
            ->where('fecha_reserva', $fecha->format('Y-m-d'))
            ->where('estado_id', '!=', 3) // No canceladas
            ->get();
        
        // Filtrar horarios disponibles
        $horariosDisponibles = [];
        foreach ($horariosBase as $hora) {
            $horaCarbon = Carbon::parse($fecha->format('Y-m-d') . ' ' . $hora);
            $disponible = true;
            
            foreach ($reservasExistentes as $reserva) {
                $inicioReserva = Carbon::parse($reserva->fecha_reserva . ' ' . $reserva->hora_inicio);
                $finReserva = Carbon::parse($reserva->fecha_reserva . ' ' . $reserva->hora_fin);
                
                if ($horaCarbon->between($inicioReserva, $finReserva->subSecond())) {
                    $disponible = false;
                    break;
                }
            }
            
            if ($disponible) {
                $horariosDisponibles[] = $hora;
            }
        }
        
        return response()->json($horariosDisponibles);
    }

    /**
     * Display reservations for a specific sports center.
     */
    public function centroReservas(\App\Models\CentroDeportivo $centro)
    {
        // Verificar autorización
        $this->authorize('view', $centro);

        // Obtener todas las reservas del centro a través de sus instalaciones
        $reservas = Reserva::whereHas('instalacion', function($query) use ($centro) {
                $query->where('centro_id', $centro->id);
            })
            ->with(['usuario', 'instalacion', 'estadoReserva'])
            ->orderBy('fecha_reserva', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->paginate(15);

        // Estadísticas
        $estadisticas = [
            'total' => Reserva::whereHas('instalacion', function($q) use ($centro) {
                $q->where('centro_id', $centro->id);
            })->count(),
            'pendientes' => Reserva::whereHas('instalacion', function($q) use ($centro) {
                $q->where('centro_id', $centro->id);
            })->where('estado_id', 1)->count(),
            'confirmadas' => Reserva::whereHas('instalacion', function($q) use ($centro) {
                $q->where('centro_id', $centro->id);
            })->where('estado_id', 2)->count(),
            'canceladas' => Reserva::whereHas('instalacion', function($q) use ($centro) {
                $q->where('centro_id', $centro->id);
            })->where('estado_id', 3)->count(),
            'completadas' => Reserva::whereHas('instalacion', function($q) use ($centro) {
                $q->where('centro_id', $centro->id);
            })->where('estado_id', 4)->count(),
        ];

        return view('propietario.centros.reservas', compact('centro', 'reservas', 'estadisticas'));
    }

    /**
     * Confirm a reservation (propietario only).
     */
    public function confirmarReserva(\App\Models\CentroDeportivo $centro, Reserva $reserva)
    {
        // Verificar autorización
        $this->authorize('update', $centro);

        // Verificar que la reserva pertenece al centro
        if ($reserva->instalacion->centro_id !== $centro->id) {
            abort(404);
        }

        // Solo se pueden confirmar reservas pendientes
        if ($reserva->estado_id !== 1) {
            return back()->with('error', 'Solo se pueden confirmar reservas pendientes.');
        }

        $reserva->update([
            'estado_id' => 2, // Confirmada
            'fecha_modificacion' => now(),
        ]);

        return back()->with('success', 'Reserva confirmada exitosamente.');
    }

    /**
     * Cancel a reservation (propietario only).
     */
    public function cancelarReserva(\App\Models\CentroDeportivo $centro, Reserva $reserva)
    {
        // Verificar autorización
        $this->authorize('update', $centro);

        // Verificar que la reserva pertenece al centro
        if ($reserva->instalacion->centro_id !== $centro->id) {
            abort(404);
        }

        // No se pueden cancelar reservas ya completadas
        if ($reserva->estado_id === 4) {
            return back()->with('error', 'No se pueden cancelar reservas completadas.');
        }

        $reserva->update([
            'estado_id' => 3, // Cancelada
            'fecha_modificacion' => now(),
        ]);

        return back()->with('success', 'Reserva cancelada exitosamente.');
    }

    // El método completarReserva se removió - las reservas se completan automáticamente
    // mediante el comando programado GestionarEstadosReservas

    /**
     * Display all reservations for the owner's centers.
     */
    public function propietarioReservas()
    {
        $propietario = Auth::user()->propietario;
        
        if (!$propietario) {
            return redirect()->route('propietario.dashboard')
                ->with('error', 'No tienes permisos de propietario.');
        }

        // Obtener todas las reservas de todos los centros del propietario
        $reservas = Reserva::whereHas('instalacion.centroDeportivo', function($query) use ($propietario) {
                $query->where('propietario_id', $propietario->id);
            })
            ->with(['usuario', 'instalacion.centroDeportivo', 'estadoReserva', 'pago'])
            ->orderBy('fecha_reserva', 'desc')
            ->orderBy('hora_inicio', 'desc')
            ->paginate(20);

        // Estadísticas generales
        $estadisticas = [
            'total' => Reserva::whereHas('instalacion.centroDeportivo', function($q) use ($propietario) {
                $q->where('propietario_id', $propietario->id);
            })->count(),
            'pendientes' => Reserva::whereHas('instalacion.centroDeportivo', function($q) use ($propietario) {
                $q->where('propietario_id', $propietario->id);
            })->where('estado_id', 1)->count(),
            'confirmadas' => Reserva::whereHas('instalacion.centroDeportivo', function($q) use ($propietario) {
                $q->where('propietario_id', $propietario->id);
            })->where('estado_id', 2)->count(),
            'canceladas' => Reserva::whereHas('instalacion.centroDeportivo', function($q) use ($propietario) {
                $q->where('propietario_id', $propietario->id);
            })->where('estado_id', 3)->count(),
            'completadas' => Reserva::whereHas('instalacion.centroDeportivo', function($q) use ($propietario) {
                $q->where('propietario_id', $propietario->id);
            })->where('estado_id', 4)->count(),
        ];

        return view('propietario.reservas.index', compact('reservas', 'estadisticas'));
    }

    /**
     * Confirm a reservation (propietario from general view).
     */
    public function confirmarReservaPropietario(Reserva $reserva)
    {
        $propietario = Auth::user()->propietario;
        
        if (!$propietario) {
            return back()->with('error', 'No tienes permisos de propietario.');
        }

        // Verificar que la reserva pertenece a un centro del propietario
        if ($reserva->instalacion->centroDeportivo->propietario_id !== $propietario->id) {
            return back()->with('error', 'No tienes permisos para gestionar esta reserva.');
        }

        // Solo se pueden confirmar reservas pendientes
        if ($reserva->estado_id !== 1) {
            return back()->with('error', 'Solo se pueden confirmar reservas pendientes.');
        }

        $reserva->update([
            'estado_id' => 2, // Confirmada
            'fecha_modificacion' => now(),
        ]);

        return back()->with('success', 'Reserva confirmada exitosamente.');
    }

    /**
     * Cancel a reservation (propietario from general view).
     */
    public function cancelarReservaPropietario(Reserva $reserva)
    {
        $propietario = Auth::user()->propietario;
        
        if (!$propietario) {
            return back()->with('error', 'No tienes permisos de propietario.');
        }

        // Verificar que la reserva pertenece a un centro del propietario
        if ($reserva->instalacion->centroDeportivo->propietario_id !== $propietario->id) {
            return back()->with('error', 'No tienes permisos para gestionar esta reserva.');
        }

        // No se pueden cancelar reservas ya completadas
        if ($reserva->estado_id === 4) {
            return back()->with('error', 'No se pueden cancelar reservas completadas.');
        }

        $reserva->update([
            'estado_id' => 3, // Cancelada
            'fecha_modificacion' => now(),
        ]);

        return back()->with('success', 'Reserva cancelada exitosamente.');
    }
}
