<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Propietario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();
        $rules = [
            'nombre' => 'required|string|max:100',
            'apellido' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'fecha_nacimiento' => 'nullable|date',
            'numero_documento' => 'nullable|string|max:20|unique:usuarios,numero_documento,' . $user->id . ',id',
            'foto_perfil' => 'nullable|image|max:2048',
        ];
        
        // Verificar si es propietario por el tipo_usuario_id
        if ($user->tipo_usuario_id === 3) { // 3 = propietario
            $rules = array_merge($rules, [
                'nombre_negocio' => 'required|string|max:200',
                'telefono_negocio' => 'required|string|max:20',
                'email_negocio' => 'required|email|max:150',
                'direccion_negocio' => 'required|string',
                'descripcion_negocio' => 'required|string',
                'logo_negocio' => 'nullable|image|max:2048',
            ]);
        }
        
        $validated = $request->validate($rules);
        
        // Foto de perfil
        if ($request->hasFile('foto_perfil')) {
            if ($user->foto_perfil) {
                Storage::delete('public/' . $user->foto_perfil);
            }
            $validated['foto_perfil'] = $request->file('foto_perfil')->store('perfiles', 'public');
        }
        
        $user->fill($validated);
        $user->save();
        
        // Si es propietario, actualizar datos del negocio
        if ($user->tipo_usuario_id === 3 && $user->propietario) {
            $propietario = $user->propietario;
            $propietario->nombre_negocio = $request->input('nombre_negocio');
            $propietario->telefono_negocio = $request->input('telefono_negocio');
            $propietario->email_negocio = $request->input('email_negocio');
            $propietario->direccion_negocio = $request->input('direccion_negocio');
            $propietario->descripcion_negocio = $request->input('descripcion_negocio');
            
            if ($request->hasFile('logo_negocio')) {
                if ($propietario->logo_negocio) {
                    Storage::delete('public/' . $propietario->logo_negocio);
                }
                $propietario->logo_negocio = $request->file('logo_negocio')->store('negocios', 'public');
            }
            $propietario->save();
        }
        
        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
