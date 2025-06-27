<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropietarioController extends Controller
{
    /**
     * Display the propietario dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Verificar que el usuario sea propietario
        if ($user->tipo_usuario !== 'propietario') {
            return redirect()->route('dashboard')->with('error', 'Acceso no autorizado.');
        }

        return view('propietario.dashboard');
    }
}
