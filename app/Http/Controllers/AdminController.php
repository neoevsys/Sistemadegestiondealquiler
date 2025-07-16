<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CentroDeportivo;
use App\Models\Instalacion;
use App\Models\Propietario;
use App\Models\Reserva;
use App\Models\Pago;
use App\Models\Evaluacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->es_admin) {
                abort(403, 'Acceso denegado. Solo administradores.');
            }
            return $next($request);
        });
    }

    public function dashboard()
    {
        // Estadísticas generales
        $estadisticas = [
            'total_usuarios' => User::count(),
            'total_propietarios' => Propietario::count(),
            'total_centros' => CentroDeportivo::count(),
            'total_instalaciones' => Instalacion::count(),
            'total_reservas' => Reserva::count(),
            'total_pagos' => Pago::where('estado_id', 1)->count(),
            'ingresos_totales' => Pago::where('estado_id', 1)->sum('monto'),
            'ingresos_mes' => Pago::where('estado_id', 1)
                ->whereMonth('fecha_pago', Carbon::now()->month)
                ->sum('monto'),
        ];

        // Estadísticas por estado
        $estadisticas_estados = [
            'usuarios_activos' => User::where('estado_id', 1)->count(),
            'usuarios_inactivos' => User::where('estado_id', 2)->count(),
            'propietarios_activos' => Propietario::where('estado_id', 1)->count(),
            'propietarios_pendientes' => Propietario::where('estado_id', 2)->count(),
            'centros_activos' => CentroDeportivo::where('estado_id', 1)->count(),
            'centros_inactivos' => CentroDeportivo::where('estado_id', 2)->count(),
            'reservas_pendientes' => Reserva::where('estado_id', 1)->count(),
            'reservas_completadas' => Reserva::where('estado_id', 4)->count(),
        ];

        // Actividad reciente
        $actividad_reciente = [
            'usuarios_nuevos' => User::latest()->take(5)->get(),
            'reservas_recientes' => Reserva::with(['usuario', 'instalacion'])
                ->latest()
                ->take(10)
                ->get(),
            'pagos_recientes' => Pago::with(['reserva.usuario', 'reserva.instalacion'])
                ->where('estado_id', 1)
                ->latest()
                ->take(10)
                ->get(),
        ];

        // Gráficos de datos
        $datos_graficos = [
            'ingresos_por_mes' => Pago::select(
                DB::raw('MONTH(fecha_pago) as mes'),
                DB::raw('SUM(monto) as total')
            )
            ->where('estado_id', 1)
            ->whereYear('fecha_pago', Carbon::now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get(),
            
            'reservas_por_mes' => Reserva::select(
                DB::raw('MONTH(fecha_creacion) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('fecha_creacion', Carbon::now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get(),
        ];

        return view('admin.dashboard', compact(
            'estadisticas',
            'estadisticas_estados',
            'actividad_reciente',
            'datos_graficos'
        ));
    }

    public function usuarios()
    {
        $usuarios = User::with(['propietario'])
            ->latest()
            ->paginate(20);

        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function toggleUsuario(User $usuario)
    {
        $nuevoEstado = $usuario->estado_id == 1 ? 2 : 1;
        $usuario->update(['estado_id' => $nuevoEstado]);

        $accion = $nuevoEstado == 1 ? 'activado' : 'suspendido';
        return back()->with('success', "Usuario {$accion} exitosamente.");
    }

    public function propietarios()
    {
        $propietarios = Propietario::with(['usuario', 'centrosDeportivos'])
            ->latest()
            ->paginate(20);

        return view('admin.propietarios.index', compact('propietarios'));
    }

    public function togglePropietario(Propietario $propietario)
    {
        $nuevoEstado = $propietario->estado_id == 1 ? 2 : 1;
        $propietario->update(['estado_id' => $nuevoEstado]);

        $accion = $nuevoEstado == 1 ? 'activado' : 'suspendido';
        return back()->with('success', "Propietario {$accion} exitosamente.");
    }

    public function centros()
    {
        $centros = CentroDeportivo::with(['propietario.usuario', 'instalaciones'])
            ->latest()
            ->paginate(20);

        return view('admin.centros.index', compact('centros'));
    }

    public function toggleCentro(CentroDeportivo $centro)
    {
        $nuevoEstado = $centro->estado_id == 1 ? 2 : 1;
        $centro->update(['estado_id' => $nuevoEstado]);

        $accion = $nuevoEstado == 1 ? 'activado' : 'suspendido';
        return back()->with('success', "Centro {$accion} exitosamente.");
    }

    public function instalaciones()
    {
        $instalaciones = Instalacion::with(['centroDeportivo.propietario.usuario'])
            ->latest()
            ->paginate(20);

        return view('admin.instalaciones.index', compact('instalaciones'));
    }

    public function toggleInstalacion(Instalacion $instalacion)
    {
        $nuevoEstado = $instalacion->estado_id == 1 ? 2 : 1;
        $instalacion->update(['estado_id' => $nuevoEstado]);

        $accion = $nuevoEstado == 1 ? 'activada' : 'suspendida';
        return back()->with('success', "Instalación {$accion} exitosamente.");
    }

    public function reservas()
    {
        $reservas = Reserva::with(['usuario', 'instalacion.centroDeportivo', 'pago'])
            ->latest()
            ->paginate(20);

        return view('admin.reservas.index', compact('reservas'));
    }

    public function pagos()
    {
        $pagos = Pago::with(['reserva.usuario', 'reserva.instalacion'])
            ->latest()
            ->paginate(20);

        $resumen_pagos = [
            'total_pagos' => Pago::where('estado_id', 1)->sum('monto'),
            'pagos_hoy' => Pago::where('estado_id', 1)
                ->whereDate('fecha_pago', Carbon::today())
                ->sum('monto'),
            'pagos_mes' => Pago::where('estado_id', 1)
                ->whereMonth('fecha_pago', Carbon::now()->month)
                ->sum('monto'),
            'pagos_año' => Pago::where('estado_id', 1)
                ->whereYear('fecha_pago', Carbon::now()->year)
                ->sum('monto'),
        ];

        return view('admin.pagos.index', compact('pagos', 'resumen_pagos'));
    }

    public function reportes()
    {
        $reportes = [
            'ingresos_diarios' => Pago::select(
                DB::raw('DATE(fecha_pago) as fecha'),
                DB::raw('SUM(monto) as total'),
                DB::raw('COUNT(*) as cantidad')
            )
            ->where('estado_id', 1)
            ->whereMonth('fecha_pago', Carbon::now()->month)
            ->groupBy('fecha')
            ->orderBy('fecha', 'desc')
            ->get(),

            'centros_mas_reservados' => CentroDeportivo::select(
                'centros_deportivos.nombre',
                DB::raw('COUNT(reservas.id) as total_reservas'),
                DB::raw('SUM(pagos.monto) as total_ingresos')
            )
            ->join('instalaciones', 'centros_deportivos.id', '=', 'instalaciones.centro_id')
            ->join('reservas', 'instalaciones.id', '=', 'reservas.instalacion_id')
            ->join('pagos', 'reservas.id', '=', 'pagos.reserva_id')
            ->where('pagos.estado_id', 1)
            ->groupBy('centros_deportivos.id', 'centros_deportivos.nombre')
            ->orderBy('total_reservas', 'desc')
            ->take(10)
            ->get(),

            'propietarios_top' => Propietario::select(
                'usuarios.nombre',
                'usuarios.email',
                DB::raw('COUNT(centros_deportivos.id) as total_centros'),
                DB::raw('SUM(pagos.monto) as total_ingresos')
            )
            ->join('usuarios', 'propietarios.usuario_id', '=', 'usuarios.id')
            ->join('centros_deportivos', 'propietarios.id', '=', 'centros_deportivos.propietario_id')
            ->join('instalaciones', 'centros_deportivos.id', '=', 'instalaciones.centro_id')
            ->join('reservas', 'instalaciones.id', '=', 'reservas.instalacion_id')
            ->join('pagos', 'reservas.id', '=', 'pagos.reserva_id')
            ->where('pagos.estado_id', 1)
            ->groupBy('propietarios.id', 'usuarios.nombre', 'usuarios.email')
            ->orderBy('total_ingresos', 'desc')
            ->take(10)
            ->get(),
        ];

        return view('admin.reportes.index', compact('reportes'));
    }

    public function ejecutarComando(Request $request)
    {
        $comando = $request->input('comando');
        
        switch ($comando) {
            case 'gestionar-estados':
                \Artisan::call('reservas:gestionar-estados');
                $output = \Artisan::output();
                return back()->with('success', 'Comando ejecutado exitosamente: ' . $output);
                
            case 'cache-clear':
                \Artisan::call('cache:clear');
                return back()->with('success', 'Cache limpiado exitosamente.');
                
            case 'config-cache':
                \Artisan::call('config:cache');
                return back()->with('success', 'Configuración cacheada exitosamente.');
                
            default:
                return back()->with('error', 'Comando no reconocido.');
        }
    }
}
