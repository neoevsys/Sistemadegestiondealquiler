<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PropietarioController extends Controller
{
    /**
     * Display the propietario dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Verificar que el usuario sea propietario
        if ($user->tipoUsuario && $user->tipoUsuario->nombre !== 'propietario') {
            return redirect()->route('dashboard')->with('error', 'Acceso no autorizado.');
        }

        return view('propietario.dashboard');
    }

    /**
     * Mostrar la página para solicitar ser propietario.
     */
    public function solicitar()
    {
        return view('propietario.solicitar');
    }

    /**
     * Procesar la solicitud para convertirse en propietario.
     */
    public function solicitarEnviar(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'telefono' => 'nullable|string|max:30',
            'motivo' => 'nullable|string|max:500',
        ]);
        // Forzar instancia Eloquent User
        $user = \App\Models\User::find($user->id_usuario);
        $user->telefono = $request->telefono;
        $user->tipo_usuario = 'propietario';
        $user->save();
        // Crear registro de propietario si no existe
        if (!$user->propietario) {
            \App\Models\Propietario::create([
                'id_propietario' => $user->id_usuario,
                'estado' => 'aprobado',
            ]);
        }
        return redirect()->route('propietario.dashboard')->with('success', '¡Ahora eres propietario!');
    }
}
