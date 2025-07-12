<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\CentroDeportivo;
use App\Policies\CentroDeportivoPolicy;
use Illuminate\Support\Facades\View; // Importa la fachada View
use App\Models\TipoDeporte;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.main', function ($view) {
            $tiposDeportes = TipoDeporte::orderBy('nombre')->get();
            $view->with('tiposDeportes', $tiposDeportes);
        });
        // Registrar políticas
        Gate::policy(CentroDeportivo::class, CentroDeportivoPolicy::class);
    }
}
