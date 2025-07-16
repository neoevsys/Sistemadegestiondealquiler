<section class="bg-blue-50 rounded-2xl p-6 shadow w-full">
    <header class="mb-6">
        <h2 class="text-lg font-bold text-blue-700 mb-2 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
            Cambiar Contraseña
        </h2>
        <p class="text-sm text-gray-600">
            Asegúrate de usar una contraseña larga y segura para mantener tu cuenta protegida.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-semibold text-gray-700 mb-1">
                Contraseña Actual
            </label>
            <input id="update_password_current_password" name="current_password" type="password" 
                   class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                   autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-semibold text-gray-700 mb-1">
                Nueva Contraseña
            </label>
            <input id="update_password_password" name="password" type="password" 
                   class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                   autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">
                Confirmar Contraseña
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                   class="w-full border border-gray-300 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                   autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex items-center gap-4 pt-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-semibold transition-colors shadow">
                Guardar Contraseña
            </button>

            @if (session('status') === 'password-updated')
                <div class="text-sm text-green-600 font-semibold">
                    ¡Contraseña actualizada!
                </div>
            @endif
        </div>
    </form>
</section>
