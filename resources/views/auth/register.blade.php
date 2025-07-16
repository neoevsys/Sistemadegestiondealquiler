@extends('layouts.main')

@section('content')
<div class="flex items-center justify-center bg-gradient-to-r from-blue-600 to-purple-600 py-12" style="min-height:calc(100vh - 8rem);">
    <div class="w-full max-w-lg">
        <div class="bg-white rounded-2xl shadow-2xl px-8 py-8">
            <div class="flex flex-col items-center mb-4">
                <div class="w-14 h-14 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center mb-2 shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-gray-800 mb-1">Crear cuenta</h1>
                <p class="text-gray-500 text-xs">Regístrate para reservar o administrar centros deportivos</p>
            </div>
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div>
                    <label for="name" class="block text-xs font-semibold text-gray-600 mb-1">Nombre</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('name')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    <div id="name-error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>
                <div>
                    <label for="apellido" class="block text-xs font-semibold text-gray-600 mb-1">Apellido (Opcional)</label>
                    <input id="apellido" type="text" name="apellido" value="{{ old('apellido') }}" autocomplete="family-name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('apellido')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label for="email" class="block text-xs font-semibold text-gray-600 mb-1">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('email')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    <div id="email-error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>
                <div>
                    <label for="telefono" class="block text-xs font-semibold text-gray-600 mb-1">Celular (Opcional)</label>
                    <input id="telefono" type="text" name="telefono" value="{{ old('telefono') }}" autocomplete="tel" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('telefono')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    <div id="telefono-error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>
                <div>
                    <label for="fecha_nacimiento" class="block text-xs font-semibold text-gray-600 mb-1">Fecha de Nacimiento (Opcional)</label>
                    <input id="fecha_nacimiento" type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('fecha_nacimiento')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    <div id="fecha_nacimiento-error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>
                <div>
                    <label for="password" class="block text-xs font-semibold text-gray-600 mb-1">Contraseña</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('password')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    <div id="password-error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>
                <div>
                    <label for="password_confirmation" class="block text-xs font-semibold text-gray-600 mb-1">Confirmar Contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('password_confirmation')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    <div id="password_confirmation-error" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>
                <div x-data="{ userType: '{{ old('tipo_usuario', 'cliente') }}', tipoDoc: '{{ old('tipo_documento_id') }}' }">
                    <label for="tipo_usuario" class="block text-xs font-semibold text-gray-600 mb-1">Tipo de Usuario</label>
                    <select id="tipo_usuario" name="tipo_usuario" x-model="userType" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="cliente">Cliente</option>
                        <option value="propietario">Propietario</option>
                    </select>
                    @error('tipo_usuario')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                    <div x-show="userType === 'propietario'" class="mt-3">
                        <label for="tipo_documento_id" class="block text-xs font-semibold text-gray-600 mb-1">Tipo de Documento</label>
                        <select id="tipo_documento_id" name="tipo_documento_id" x-model="tipoDoc" :required="userType === 'propietario'" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Selecciona un tipo</option>
                            @foreach($tiposDocumento as $tipo)
                                <option value="{{ $tipo->id }}" {{ old('tipo_documento_id') == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                        @error('tipo_documento_id')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                        <div id="tipo_documento_id-error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>
                    <div x-show="userType === 'propietario'" class="mt-3">
                        <label for="numero_documento" class="block text-xs font-semibold text-gray-600 mb-1">Número de Documento</label>
                        <input id="numero_documento" type="text" name="numero_documento" value="{{ old('numero_documento') }}" :required="userType === 'propietario'" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('numero_documento')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                        <div id="numero_documento-error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>
                    <div x-show="userType === 'propietario' && tipoDoc == '2'" class="mt-3">
                        <label for="razon_social" class="block text-xs font-semibold text-gray-600 mb-1">Razón Social (solo para RUC)</label>
                        <input id="razon_social" type="text" name="razon_social" value="{{ old('razon_social') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('razon_social')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                        <div id="razon_social-error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>
                    <div class="mt-3">
                        <label for="foto_perfil" class="block text-xs font-semibold text-gray-600 mb-1">Foto de Perfil Personal (Opcional)</label>
                        <input id="foto_perfil" type="file" name="foto_perfil" accept="image/*" class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                        <p class="mt-1 text-xs text-gray-500" id="file_input_help">SVG, PNG, JPG o GIF (MAX. 2MB).</p>
                        @error('foto_perfil')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                        <div id="foto_perfil-error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>
                    <div x-show="userType === 'propietario'" class="mt-3">
                        <label for="logo_negocio" class="block text-xs font-semibold text-gray-600 mb-1">Logo del Negocio (Opcional)</label>
                        <input id="logo_negocio" type="file" name="logo_negocio" accept="image/*" class="w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                        <p class="mt-1 text-xs text-gray-500" id="file_input_help_negocio">SVG, PNG, JPG o GIF (MAX. 2MB).</p>
                        @error('logo_negocio')<div class="text-red-500 text-xs mt-1">{{ $message }}</div>@enderror
                        <div id="logo_negocio-error" class="text-red-500 text-xs mt-1 hidden"></div>
                    </div>
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white py-2 rounded-lg font-semibold shadow transition-colors mt-2">Registrarse</button>
                <div class="text-center mt-2 text-xs text-gray-600">
                    ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-semibold">Inicia sesión</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reglas de validación
    const validationRules = {
        name: {
            required: true,
            minLength: 2,
            maxLength: 100,
            pattern: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/,
            messages: {
                required: 'El campo nombre es obligatorio.',
                minLength: 'El nombre debe tener al menos 2 caracteres.',
                maxLength: 'El nombre no puede ser mayor que 100 caracteres.',
                pattern: 'El nombre solo puede contener letras.'
            }
        },
        email: {
            required: true,
            maxLength: 150,
            pattern: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
            messages: {
                required: 'El campo correo electrónico es obligatorio.',
                maxLength: 'El correo electrónico no puede ser mayor que 150 caracteres.',
                pattern: 'El campo correo electrónico debe ser una dirección de correo válida.'
            }
        },
        telefono: {
            required: false,
            pattern: /^9\d{8}$/,
            messages: {
            pattern: 'El número de celular debe comenzar con 9 y tener exactamente 9 dígitos.'
            }
        },
        fecha_nacimiento: {
            required: false,
            validate: function(value) {
                if (!value) return true;
                const today = new Date();
                const birthDate = new Date(value);
                const age = today.getFullYear() - birthDate.getFullYear();
                return age >= 13 && age <= 100;
            },
            messages: {
                validate: 'Debes tener entre 13 y 100 años para registrarte.'
            }
        },
        password: {
            required: true,
            minLength: 8,
            messages: {
                required: 'El campo contraseña es obligatorio.',
                minLength: 'La contraseña debe tener al menos 8 caracteres.'
            }
        },
        password_confirmation: {
            required: true,
            validate: function(value) {
                const password = document.getElementById('password').value;
                return value === password;
            },
            messages: {
                required: 'El campo confirmación de contraseña es obligatorio.',
                validate: 'La confirmación del campo contraseña no coincide.'
            }
        },
        tipo_documento_id: {
            required: function() {
                const userType = document.getElementById('tipo_usuario').value;
                return userType === 'propietario';
            },
            messages: {
                required: 'El campo tipo de documento es obligatorio.'
            }
        },
        numero_documento: {
            required: function() {
                const userType = document.getElementById('tipo_usuario').value;
                return userType === 'propietario';
            },
            validate: function(value) {
                if (!value) return true;
                const tipoDoc = document.getElementById('tipo_documento_id').value;
                
                // DNI: 8 dígitos
                if (tipoDoc === '1') {
                    return /^\d{8}$/.test(value);
                }
                // RUC: 11 dígitos
                else if (tipoDoc === '2') {
                    return /^\d{11}$/.test(value);
                }
                // Otros tipos: al menos 6 caracteres
                return value.length >= 6;
            },
            messages: {
                required: 'El campo número de documento es obligatorio.',
                validate: 'El número de documento no tiene el formato correcto.'
            }
        },
        razon_social: {
            required: function() {
                const userType = document.getElementById('tipo_usuario').value;
                const tipoDoc = document.getElementById('tipo_documento_id').value;
                return userType === 'propietario' && tipoDoc === '2';
            },
            minLength: 3,
            maxLength: 200,
            messages: {
                required: 'El campo razón social es obligatorio para RUC.',
                minLength: 'La razón social debe tener al menos 3 caracteres.',
                maxLength: 'La razón social no puede ser mayor que 200 caracteres.'
            }
        },
        foto_perfil: {
            required: false,
            validate: function(files) {
                if (!files || files.length === 0) return true;
                
                const file = files[0];
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml'];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                if (!allowedTypes.includes(file.type)) {
                    return false;
                }
                
                if (file.size > maxSize) {
                    return false;
                }
                
                return true;
            },
            messages: {
                validate: 'El archivo debe ser una imagen válida (JPG, PNG, GIF, SVG) y no debe superar los 2MB.'
            }
        },
        logo_negocio: {
            required: false,
            validate: function(files) {
                if (!files || files.length === 0) return true;
                
                const file = files[0];
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml'];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                if (!allowedTypes.includes(file.type)) {
                    return false;
                }
                
                if (file.size > maxSize) {
                    return false;
                }
                
                return true;
            },
            messages: {
                validate: 'El archivo debe ser una imagen válida (JPG, PNG, GIF, SVG) y no debe superar los 2MB.'
            }
        }
    };

    // Función para validar un campo
    function validateField(fieldName, value) {
        const rules = validationRules[fieldName];
        if (!rules) return { valid: true, message: '' };

        // Determinar si es requerido (puede ser boolean o función)
        const isRequired = typeof rules.required === 'function' ? rules.required() : rules.required;

        // Para campos de archivo, usar files en lugar de value
        if (fieldName === 'foto_perfil' || fieldName === 'logo_negocio') {
            const fileInput = document.getElementById(fieldName);
            const files = fileInput ? fileInput.files : null;
            
            // Validar si es requerido
            if (isRequired && (!files || files.length === 0)) {
                return { valid: false, message: rules.messages.required };
            }

            // Si no es requerido y no hay archivos, es válido
            if (!isRequired && (!files || files.length === 0)) {
                return { valid: true, message: '' };
            }

            // Validación personalizada para archivos
            if (rules.validate && !rules.validate(files)) {
                return { valid: false, message: rules.messages.validate };
            }

            return { valid: true, message: '' };
        }

        // Validación para campos de texto normales
        // Validar si es requerido
        if (isRequired && (!value || value.trim() === '')) {
            return { valid: false, message: rules.messages.required };
        }

        // Si no es requerido y está vacío, es válido
        if (!isRequired && (!value || value.trim() === '')) {
            return { valid: true, message: '' };
        }

        // Validar longitud mínima
        if (rules.minLength && value.length < rules.minLength) {
            return { valid: false, message: rules.messages.minLength };
        }

        // Validar longitud máxima
        if (rules.maxLength && value.length > rules.maxLength) {
            return { valid: false, message: rules.messages.maxLength };
        }

        // Validar patrón
        if (rules.pattern && !rules.pattern.test(value)) {
            return { valid: false, message: rules.messages.pattern };
        }

        // Validación personalizada
        if (rules.validate && !rules.validate(value)) {
            return { valid: false, message: rules.messages.validate };
        }

        return { valid: true, message: '' };
    }

    // Función para mostrar error
    function showError(fieldName, message) {
        const errorDiv = document.getElementById(fieldName + '-error');
        const input = document.getElementById(fieldName);
        
        if (errorDiv) {
            errorDiv.textContent = message;
            errorDiv.classList.remove('hidden');
        }
        
        if (input) {
            input.classList.remove('border-gray-300', 'focus:ring-blue-500');
            input.classList.add('border-red-500', 'focus:ring-red-500');
        }
    }

    // Función para limpiar error
    function clearError(fieldName) {
        const errorDiv = document.getElementById(fieldName + '-error');
        const input = document.getElementById(fieldName);
        
        if (errorDiv) {
            errorDiv.textContent = '';
            errorDiv.classList.add('hidden');
        }
        
        if (input) {
            input.classList.remove('border-red-500', 'focus:ring-red-500');
            input.classList.add('border-gray-300', 'focus:ring-blue-500');
        }
    }

    // Agregar eventos de validación a los campos
    Object.keys(validationRules).forEach(fieldName => {
        const field = document.getElementById(fieldName);
        if (field) {
            field.addEventListener('blur', function() {
                const validation = validateField(fieldName, this.value);
                if (!validation.valid) {
                    showError(fieldName, validation.message);
                } else {
                    clearError(fieldName);
                }
            });

            // Limpiar error al escribir
            field.addEventListener('input', function() {
                const errorDiv = document.getElementById(fieldName + '-error');
                if (errorDiv && !errorDiv.classList.contains('hidden')) {
                    const validation = validateField(fieldName, this.value);
                    if (validation.valid) {
                        clearError(fieldName);
                    }
                }
            });
        }
    });

    // Validación especial para confirmación de contraseña
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password_confirmation');
    
    if (passwordField && confirmPasswordField) {
        passwordField.addEventListener('input', function() {
            // Si ya hay algo en confirmación, revalidar
            if (confirmPasswordField.value) {
                const validation = validateField('password_confirmation', confirmPasswordField.value);
                if (!validation.valid) {
                    showError('password_confirmation', validation.message);
                } else {
                    clearError('password_confirmation');
                }
            }
        });
    }

    // Validación de email único (simulada - en producción sería una consulta AJAX)
    const emailField = document.getElementById('email');
    if (emailField) {
        emailField.addEventListener('blur', function() {
            const email = this.value.trim();
            if (email) {
                // Aquí podrías agregar una validación AJAX para verificar si el email existe
                // Por ahora solo validamos formato
                const validation = validateField('email', email);
                if (!validation.valid) {
                    showError('email', validation.message);
                } else {
                    clearError('email');
                }
            }
        });
    }

    // Validación especial para campos de propietario
    const tipoUsuarioField = document.getElementById('tipo_usuario');
    const tipoDocumentoField = document.getElementById('tipo_documento_id');
    const numeroDocumentoField = document.getElementById('numero_documento');
    const razonSocialField = document.getElementById('razon_social');

    // Cuando cambie el tipo de usuario, revalidar campos de propietario
    if (tipoUsuarioField) {
        tipoUsuarioField.addEventListener('change', function() {
            // Revalidar tipo de documento
            if (tipoDocumentoField) {
                const validation = validateField('tipo_documento_id', tipoDocumentoField.value);
                if (!validation.valid) {
                    showError('tipo_documento_id', validation.message);
                } else {
                    clearError('tipo_documento_id');
                }
            }

            // Revalidar número de documento
            if (numeroDocumentoField) {
                const validation = validateField('numero_documento', numeroDocumentoField.value);
                if (!validation.valid) {
                    showError('numero_documento', validation.message);
                } else {
                    clearError('numero_documento');
                }
            }

            // Revalidar razón social
            if (razonSocialField) {
                const validation = validateField('razon_social', razonSocialField.value);
                if (!validation.valid) {
                    showError('razon_social', validation.message);
                } else {
                    clearError('razon_social');
                }
            }
        });
    }

    // Cuando cambie el tipo de documento, revalidar número de documento y razón social
    if (tipoDocumentoField) {
        tipoDocumentoField.addEventListener('change', function() {
            // Revalidar número de documento
            if (numeroDocumentoField) {
                const validation = validateField('numero_documento', numeroDocumentoField.value);
                if (!validation.valid) {
                    showError('numero_documento', validation.message);
                } else {
                    clearError('numero_documento');
                }
            }

            // Revalidar razón social
            if (razonSocialField) {
                const validation = validateField('razon_social', razonSocialField.value);
                if (!validation.valid) {
                    showError('razon_social', validation.message);
                } else {
                    clearError('razon_social');
                }
            }
        });
    }

    // Validación especial para campos de archivo
    const fotoPerfilField = document.getElementById('foto_perfil');
    const logoNegocioField = document.getElementById('logo_negocio');

    // Validar foto de perfil cuando se seleccione un archivo
    if (fotoPerfilField) {
        fotoPerfilField.addEventListener('change', function() {
            const validation = validateField('foto_perfil', null);
            if (!validation.valid) {
                showError('foto_perfil', validation.message);
                // Limpiar el input si el archivo no es válido
                this.value = '';
            } else {
                clearError('foto_perfil');
            }
        });
    }

    // Validar logo de negocio cuando se seleccione un archivo
    if (logoNegocioField) {
        logoNegocioField.addEventListener('change', function() {
            const validation = validateField('logo_negocio', null);
            if (!validation.valid) {
                showError('logo_negocio', validation.message);
                // Limpiar el input si el archivo no es válido
                this.value = '';
            } else {
                clearError('logo_negocio');
            }
        });
    }
});
</script>

@endsection
