<section class="bg-red-50 rounded-2xl p-6 shadow w-full">
    <header class="mb-6">
        <h2 class="text-lg font-bold text-red-700 mb-2 flex items-center gap-2">
            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
            Eliminar Cuenta
        </h2>
        <p class="text-sm text-gray-600">
            Una vez que elimines tu cuenta, todos los datos serán borrados permanentemente. Esta acción no se puede deshacer.
        </p>
    </header>

    <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
        @csrf
        @method('delete')

        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                Confirma tu contraseña para continuar
            </label>
            <input id="password" name="password" type="password" 
                   class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent" 
                   placeholder="Introduce tu contraseña actual">
            @error('password', 'userDeletion')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" 
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl font-semibold transition-colors shadow"
                    onclick="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.')">
                Eliminar Cuenta
            </button>
            <span class="text-sm text-gray-500">Esta acción es irreversible</span>
        </div>
    </form>
</section>
