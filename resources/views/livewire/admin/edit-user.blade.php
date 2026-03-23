{{-- resources/views/livewire/admin/edit-user.blade.php --}}

<div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800">Editar Usuario</h1>
                <button wire:click="cancel" class="text-gray-600 hover:text-gray-900">
                    ← Volver
                </button>
            </div>
        </div>
        
        <!-- Mensajes -->
        @if (session()->has('message'))
            <div class="m-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('message') }}
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="m-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif
        
        <!-- Formulario -->
        <form wire:submit.prevent="updateUser" class="p-6">
            <!-- Nombre -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nombre completo *
                </label>
                <input type="text" 
                       id="name" 
                       wire:model="name" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                       required>
                @error('name') 
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
                @enderror
            </div>
            
            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Correo electrónico *
                </label>
                <input type="email" 
                       id="email" 
                       wire:model="email" 
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                       required>
                @error('email') 
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
                @enderror
            </div>
            
            <!-- Tipo de usuario -->
            <div class="mb-6">
                <label for="user_type" class="block text-sm font-medium text-gray-700 mb-2">
                    Tipo de usuario *
                </label>
                <select id="user_type" 
                        wire:model="user_type" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="user">Usuario Normal</option>
                    <option value="employee">Empleado</option>
                    <option value="admin">Administrador</option>
                </select>
                @error('user_type') 
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
                @enderror
            </div>
            
            <!-- Estado -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="is_active" 
                           wire:model="is_active" 
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label for="is_active" class="ml-2 block text-sm text-gray-700">
                        Usuario activo
                    </label>
                </div>
                @error('is_active') 
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
                @enderror
                <p class="text-xs text-gray-500 mt-1">
                    Si desactivas el usuario, no podrá iniciar sesión.
                </p>
            </div>
            
            <!-- Opción de cambiar contraseña -->
            <div class="mb-6">
                <div class="flex items-center">
                    <input type="checkbox" 
                           id="updatePassword" 
                           wire:model="updatePassword" 
                           class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <label for="updatePassword" class="ml-2 block text-sm text-gray-700">
                        Cambiar contraseña
                    </label>
                </div>
            </div>
            
            <!-- Campos de contraseña (se muestran solo si updatePassword es true) -->
            @if($updatePassword)
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Nueva contraseña *
                    </label>
                    <input type="password" 
                           id="password" 
                           wire:model="password" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('password') 
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
                    @enderror
                    <p class="text-xs text-gray-500 mt-1">
                        Mínimo 8 caracteres, debe incluir letras, números y símbolos.
                    </p>
                </div>
                
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Confirmar nueva contraseña *
                    </label>
                    <input type="password" 
                           id="password_confirmation" 
                           wire:model="password_confirmation" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            @endif
            
            <!-- Información adicional -->
            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Información del usuario</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">ID:</span>
                        <span class="ml-2 text-gray-900">{{ $user->id }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Creado:</span>
                        <span class="ml-2 text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Última actualización:</span>
                        <span class="ml-2 text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @if($user->email_verified_at)
                        <div>
                            <span class="text-gray-500">Email verificado:</span>
                            <span class="ml-2 text-green-600">Sí ({{ $user->email_verified_at->format('d/m/Y') }})</span>
                        </div>
                    @else
                        <div>
                            <span class="text-gray-500">Email verificado:</span>
                            <span class="ml-2 text-red-600">No</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Botones de acción -->
            <div class="flex justify-end space-x-3">
                <button type="button" 
                        wire:click="cancel" 
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Cancelar
                </button>
                
                <button type="submit" 
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>