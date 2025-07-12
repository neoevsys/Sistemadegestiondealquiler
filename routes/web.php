<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PropietarioController;
use App\Http\Controllers\CentroDeportivoController;
use App\Http\Controllers\InstalacionController;
use App\Http\Controllers\TipoDeporteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

// Rutas de autenticación generadas por Breeze (login, register, etc.)
require __DIR__ . '/auth.php';
// Esta será tu página de inicio unificada
Route::get('/', [CentroDeportivoController::class, 'index'])->name('home'); // Cambiado para usar el index de CentroDeportivoController

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
    return view('welcome', compact('departamentos', 'provincias', 'distritos', 'deportes'));
})->name('welcome');

Route::get('/centros', [CentroDeportivoController::class, 'index'])->name('centros.index');
Route::get('/instalaciones', [InstalacionController::class, 'index'])->name('instalaciones.index');
Route::get('/deportes', [TipoDeporteController::class, 'index'])->name('tipos_deportes.index');

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
    });

    // Rutas de perfil (generadas por Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/show', function() { return view('profile.show'); })->name('profile.show');

    Route::get('/reservas', [\App\Http\Controllers\ReservaController::class, 'index'])->name('reservas.index');
    Route::get('/propietario/solicitar', [\App\Http\Controllers\PropietarioController::class, 'solicitar'])->name('propietario.solicitar');
    Route::post('/propietario/solicitar', [\App\Http\Controllers\PropietarioController::class, 'solicitarEnviar'])->name('propietario.solicitar.enviar');
});

// Ruta pública para ver el detalle de un centro deportivo
Route::get('/centros/{id}', [CentroDeportivoController::class, 'showPublic'])->name('centros.show');
