<?php

namespace App\Policies;

use App\Models\CentroDeportivo;
use App\Models\User;

class CentroDeportivoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->tipoUsuario?->nombre === 'propietario' || $user->tipoUsuario?->nombre === 'administrador';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CentroDeportivo $centroDeportivo): bool
    {
        // Administradores pueden ver todos los centros
        if ($user->tipoUsuario?->nombre === 'administrador') {
            return true;
        }

        // Propietarios solo pueden ver sus propios centros
        if ($user->tipoUsuario?->nombre === 'propietario' && $user->propietario) {
            return $centroDeportivo->propietario_id === $user->propietario->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->tipoUsuario?->nombre === 'propietario' && $user->propietario !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CentroDeportivo $centroDeportivo): bool
    {
        // Administradores pueden editar todos los centros
        if ($user->tipoUsuario?->nombre === 'administrador') {
            return true;
        }

        // Propietarios solo pueden editar sus propios centros
        if ($user->tipoUsuario?->nombre === 'propietario' && $user->propietario) {
            return $centroDeportivo->propietario_id === $user->propietario->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CentroDeportivo $centroDeportivo): bool
    {
        // Administradores pueden eliminar todos los centros
        if ($user->tipoUsuario?->nombre === 'administrador') {
            return true;
        }

        // Propietarios solo pueden eliminar sus propios centros
        if ($user->tipoUsuario?->nombre === 'propietario' && $user->propietario) {
            return $centroDeportivo->propietario_id === $user->propietario->id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CentroDeportivo $centroDeportivo): bool
    {
        return $this->delete($user, $centroDeportivo);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CentroDeportivo $centroDeportivo): bool
    {
        return $user->tipoUsuario?->nombre === 'administrador';
    }
}
