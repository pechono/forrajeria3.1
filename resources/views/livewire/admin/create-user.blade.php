{{-- resources/views/livewire/admin/create-user.blade.php --}}

<div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-600 to-indigo-700">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-white">Crear Nuevo Usuario</h1>
                    <p class="mt-1 text-sm text-indigo-100">
                        Complete los datos para crear un nuevo usuario en el sistema
                    </p>
                </div>
                <a href="{{ route('admin.users') }}" 
                   class="text-white hover:text-indigo-200 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </a>
            </div>
        </div>
        
        <!-- Mensajes de notificación -->
        @if (session()->has('message'))
            <div class="m-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('message') }}</span>
                </div>
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="m-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm" role="alert">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
        
        <!-- Formulario -->
        <form wire:submit.prevent="createUser" class="p-6 space-y-6">
            <!-- Nombre completo -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nombre completo <span class="text-red-500">*</span>
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input type="text" 
                           id="name" 
                           wire:model="name" 
                           placeholder="Ej: Juan Pérez"
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm"
                           required>
                </div>
                @error('name') 
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Correo electrónico <span class="text-red-500">*</span>
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <input type="email" 
                           id="email" 
                           wire:model="email" 
                           placeholder="Ej: juan.perez@ejemplo.com"
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm"
                           required>
                </div>
                @error('email') 
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Contraseña -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Contraseña <span class="text-red-500">*</span>
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6-4h12a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2v-6a2 2 0 012-2zm10-4V6a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input type="password" 
                           id="password" 
                           wire:model="password" 
                           placeholder="Mínimo 8 caracteres"
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm"
                           required>
                </div>
                @error('password') 
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">
                    La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas, números y símbolos.
                </p>
            </div>
            
            <!-- Confirmar contraseña -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirmar contraseña <span class="text-red-500">*</span>
                </label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <input type="password" 
                           id="password_confirmation" 
                           wire:model="password_confirmation" 
                           placeholder="Repite la contraseña"
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out sm:text-sm"
                           required>
                </div>
                @error('password_confirmation') 
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Tipo de usuario -->
            <div>
                <label for="user_type" class="block text-sm font-medium text-gray-700 mb-2">
                    Tipo de usuario <span class="text-red-500">*</span>
                </label>
                <select id="user_type" 
                        wire:model="user_type" 
                        class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="user">👤 Usuario Normal</option>
                    <option value="employee">👨‍💼 Empleado</option>
                    <option value="admin">👑 Administrador</option>
                </select>
                @error('user_type') 
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
                <div class="mt-2 text-xs text-gray-500">
                    <p><strong>Usuario Normal:</strong> Solo acceso básico al sistema.</p>
                    <p><strong>Empleado:</strong> Acceso a funciones operativas.</p>
                    <p><strong>Administrador:</strong> Acceso total incluyendo gestión de usuarios.</p>
                </div>
            </div>
            
            <!-- Estado (activo/inactivo) -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Estado inicial
                </label>
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" 
                               wire:model="is_active" 
                               value="1" 
                               class="form-radio h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300">
                        <span class="ml-2 text-sm text-gray-700">
                            <span class="inline-flex items-center">
                                <svg class="h-4 w-4 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Activo
                            </span>
                        </span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" 
                               wire:model="is_active" 
                               value="0" 
                               class="form-radio h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300">
                        <span class="ml-2 text-sm text-gray-700">
                            <span class="inline-flex items-center">
                                <svg class="h-4 w-4 text-gray-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Inactivo
                            </span>
                        </span>
                    </label>
                </div>
                <p class="mt-1 text-xs text-gray-500">
                    Si el usuario se crea como inactivo, no podrá iniciar sesión hasta que sea habilitado.
                </p>
            </div>
            
            <!-- Divider -->
            <div class="border-t border-gray-200 my-6"></div>
            
            <!-- Botones de acción -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.users') }}" 
                   class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    Cancelar
                </a>
                
                <button type="submit" 
                        wire:loading.attr="disabled"
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    <span wire:loading.remove wire:target="createUser">
                        <svg class="h-4 w-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Crear Usuario
                    </span>
                    <span wire:loading wire:target="createUser">
                        <svg class="animate-spin h-4 w-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Creando...
                    </span>
                </button>
            </div>
        </form>
        
        <!-- Información adicional -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex items-start space-x-2">
                <svg class="h-5 w-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-xs text-gray-500">
                    <p>Al crear un usuario, se enviará automáticamente un correo de bienvenida con instrucciones para configurar su cuenta.</p>
                    <p class="mt-1">Los usuarios inactivos no podrán iniciar sesión hasta que un administrador los active.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-ocultar mensajes después de 5 segundos
    setTimeout(function() {
        let alerts = document.querySelectorAll('[role="alert"]');
        alerts.forEach(function(alert) {
            alert.style.display = 'none';
        });
    }, 5000);
</script>
@endpush
