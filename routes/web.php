<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PropietarioController;
use App\Http\Controllers\CentroDeportivoController;
use App\Http\Controllers\InstalacionController;
use App\Http\Controllers\TipoDeporteController;
use App\Models\TipoDeporte;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Rutas de autenticación generadas por Breeze (login, register, etc.)
require __DIR__ . '/auth.php';
// Esta será tu página de inicio unificada
Route::get('/', [CentroDeportivoController::class, 'welcome'])->name('home'); // Cambiado para usar el index de CentroDeportivoController

// Ruta para la landing page (welcome)
Route::get('/welcome', function() {
    // Solo ubigeos con centros registrados
    $centros = DB::table('centros_deportivos')->select('departamento_id', 'provincia_id', 'distrito_id')->get();
    $departamentoIds = $centros->pluck('departamento_id')->unique();
    $provinciaIds = $centros->pluck('provincia_id')->unique();
    $distritoIds = $centros->pluck('distrito_id')->unique();
    $departamentos = DB::table('departamentos')->whereIn('id', $departamentoIds)->orderBy('nombre')->get();
    $provincias = DB::table('provincias')->whereIn('id', $provinciaIds)->orderBy('nombre')->get();
    $distritos = DB::table('distritos')->whereIn('id', $distritoIds)->orderBy('nombre')->get();
    $deportes = DB::table('tipos_deportes')->pluck('nombre');
    $tiposDeportes = TipoDeporte::orderBy('nombre')->get();
    return view('welcome', compact('departamentos', 'provincias', 'distritos', 'deportes', 'tiposDeportes'));
})->name('welcome');

Route::get('/centros', [CentroDeportivoController::class, 'index'])->name('centros.index');
Route::get('/instalaciones', [InstalacionController::class, 'index'])->name('instalaciones.index');
Route::get('/deportes', [TipoDeporteController::class, 'index'])->name('tipos_deportes.index');
Route::get('/centros/{id}', [CentroDeportivoController::class, 'showPublic'])->name('centros.show');
Route::get('/faq', [\App\Http\Controllers\FaqController::class, 'index'])->name('faq.index');

// Ruta del dashboard general (por defecto de Breeze)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
// --- Nuevas rutas para dashboards específicos de rol ---
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard para clientes
    Route::get('/cliente/dashboard', [ClienteController::class, 'dashboard'])->name('cliente.dashboard');

    // Dashboard para propietarios
    Route::get('/propietario/dashboard', [PropietarioController::class, 'dashboard'])->name('propietario.dashboard');

    // Rutas para propietarios
    Route::prefix('propietario')->name('propietario.')->group(function () {
        // Rutas de centros deportivos
        Route::resource('centros', \App\Http\Controllers\CentroDeportivoController::class);

        // Ruta adicional para toggle de estado
        Route::patch('centros/{centro}/toggle-status',
                    [\App\Http\Controllers\CentroDeportivoController::class, 'toggleStatus'])
                    ->name('centros.toggle-status');

        // Rutas de gestión de reservas del propietario
        Route::get('reservas', [\App\Http\Controllers\ReservaController::class, 'propietarioReservas'])
                    ->name('reservas.index');
        Route::post('reservas/{reserva}/confirmar', [\App\Http\Controllers\ReservaController::class, 'confirmarReservaPropietario'])
                    ->name('reservas.confirmar');
        Route::post('reservas/{reserva}/cancelar', [\App\Http\Controllers\ReservaController::class, 'cancelarReservaPropietario'])
                    ->name('reservas.cancelar');

        // Rutas anidadas para centros deportivos
        Route::prefix('centros/{centro}')->name('centros.')->group(function () {
            // Instalaciones
            Route::resource('instalaciones', \App\Http\Controllers\InstalacionController::class)->parameters([
                'instalaciones' => 'instalacion'
            ]);
            
            // Reservas del centro
            Route::get('reservas', [\App\Http\Controllers\ReservaController::class, 'centroReservas'])
                ->name('reservas');
            
            // Acciones de reservas para propietarios
            Route::post('reservas/{reserva}/confirmar', [\App\Http\Controllers\ReservaController::class, 'confirmarReserva'])
                ->name('reservas.confirmar');
            Route::post('reservas/{reserva}/cancelar', [\App\Http\Controllers\ReservaController::class, 'cancelarReserva'])
                ->name('reservas.cancelar');
            
            // Evaluaciones del centro
            Route::get('evaluaciones', [\App\Http\Controllers\CentroDeportivoController::class, 'evaluaciones'])
                ->name('evaluaciones');
        });
    });

    // Rutas de perfil (generadas por Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/show', function() { return view('profile.show'); })->name('profile.show');

    // Rutas de reservas
    Route::get('/reservas', [\App\Http\Controllers\ReservaController::class, 'index'])->name('reservas.index');
    Route::get('/reservas/crear', [\App\Http\Controllers\ReservaController::class, 'create'])->name('reservas.create');
    Route::post('/reservas', [\App\Http\Controllers\ReservaController::class, 'store'])->name('reservas.store');
    Route::get('/reservas/{id}', [\App\Http\Controllers\ReservaController::class, 'show'])->name('reservas.show');
    Route::post('/reservas/{id}/cancelar', [\App\Http\Controllers\ReservaController::class, 'cancel'])->name('reservas.cancel');
    Route::get('/api/horarios-disponibles', [\App\Http\Controllers\ReservaController::class, 'getAvailableHours'])->name('reservas.horarios');
    
    // Rutas de evaluaciones
    Route::get('/evaluaciones/crear/{reserva}', [\App\Http\Controllers\EvaluacionController::class, 'create'])->name('evaluaciones.create');
    Route::post('/evaluaciones/{reserva}', [\App\Http\Controllers\EvaluacionController::class, 'store'])->name('evaluaciones.store');
    Route::get('/evaluaciones/{evaluacion}', [\App\Http\Controllers\EvaluacionController::class, 'show'])->name('evaluaciones.show');
    
    // Rutas de pagos
    Route::get('/pagos/{reserva}', [\App\Http\Controllers\PagoController::class, 'showPaymentForm'])->name('pagos.form');
    Route::post('/api/pagos/crear-token', [\App\Http\Controllers\PagoController::class, 'createPaymentToken'])->name('pagos.create-token');
    Route::post('/api/pagos/procesar', [\App\Http\Controllers\PagoController::class, 'processPayment'])->name('pagos.process');
    Route::get('/pagos/exito/{reserva}', [\App\Http\Controllers\PagoController::class, 'paymentSuccess'])->name('pagos.success');
    Route::get('/pagos/rechazado/{reserva}', [\App\Http\Controllers\PagoController::class, 'paymentRefused'])->name('pagos.refused');
    Route::get('/propietario/solicitar', [\App\Http\Controllers\PropietarioController::class, 'solicitar'])->name('propietario.solicitar');
    Route::post('/propietario/solicitar', [\App\Http\Controllers\PropietarioController::class, 'solicitarEnviar'])->name('propietario.solicitar.enviar');
});

// Rutas del administrador
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    
    // Gestión de usuarios
    Route::get('/usuarios', [\App\Http\Controllers\AdminController::class, 'usuarios'])->name('usuarios.index');
    Route::post('/usuarios/{usuario}/toggle', [\App\Http\Controllers\AdminController::class, 'toggleUsuario'])->name('usuarios.toggle');
    
    // Gestión de propietarios
    Route::get('/propietarios', [\App\Http\Controllers\AdminController::class, 'propietarios'])->name('propietarios.index');
    Route::post('/propietarios/{propietario}/toggle', [\App\Http\Controllers\AdminController::class, 'togglePropietario'])->name('propietarios.toggle');
    
    // Gestión de centros deportivos
    Route::get('/centros', [\App\Http\Controllers\AdminController::class, 'centros'])->name('centros.index');
    Route::post('/centros/{centro}/toggle', [\App\Http\Controllers\AdminController::class, 'toggleCentro'])->name('centros.toggle');
    
    // Gestión de instalaciones
    Route::get('/instalaciones', [\App\Http\Controllers\AdminController::class, 'instalaciones'])->name('instalaciones.index');
    Route::post('/instalaciones/{instalacion}/toggle', [\App\Http\Controllers\AdminController::class, 'toggleInstalacion'])->name('instalaciones.toggle');
    
    // Gestión de reservas
    Route::get('/reservas', [\App\Http\Controllers\AdminController::class, 'reservas'])->name('reservas.index');
    
    // Gestión de pagos
    Route::get('/pagos', [\App\Http\Controllers\AdminController::class, 'pagos'])->name('pagos.index');
    
    // Reportes
    Route::get('/reportes', [\App\Http\Controllers\AdminController::class, 'reportes'])->name('reportes.index');
    
    // Comandos del sistema
    Route::post('/comandos/ejecutar', [\App\Http\Controllers\AdminController::class, 'ejecutarComando'])->name('comandos.ejecutar');
});
