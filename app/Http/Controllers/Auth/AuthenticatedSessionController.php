<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); // Intenta autenticar al usuario
        $request->session()->regenerate(); // Regenera la sesión
        // --- Lógica de redirección basada en el rol ---
        $user = Auth::user(); // Obtener el usuario autenticado
        if ($user->tipo_usuario === 'propietario') {
            return redirect()->intended(route('home')); // O a una ruta específica si quieres un dashboard de propietario
        } elseif ($user->tipo_usuario === 'cliente') {
            return redirect()->intended(route('home')); // O a una ruta específica si quieres un dashboard de cliente
        }
        return redirect()->intended(route('home')); // Redirección por defecto

    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
