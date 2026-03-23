<div>
    <!-- Mensajes de notificación -->
    @if($message)
        <div class="fixed top-4 right-4 z-50 animate-fade-in-down" x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show">
            <div class="rounded-lg shadow-lg p-4 {{ $messageType === 'success' ? 'bg-green-500' : 'bg-red-500' }} text-white">
                <div class="flex items-center">
                    @if($messageType === 'success')
                        <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    @else
                        <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    @endif
                    {{ $message }}
                </div>
            </div>
        </div>
    @endif

    <!-- Header con estadísticas -->
    <div class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-blue-100 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-800 text-sm font-semibold">Total Usuarios</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $totalCount }}</p>
                </div>
                <svg class="h-10 w-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
        
        <div class="bg-green-100 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-800 text-sm font-semibold">Administradores</p>
                    <p class="text-2xl font-bold text-green-900">{{ $adminCount }}</p>
                </div>
                <svg class="h-10 w-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        
        <div class="bg-yellow-100 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-800 text-sm font-semibold">Operadores</p>
                    <p class="text-2xl font-bold text-yellow-900">{{ $operatorCount }}</p>
                </div>
                <svg class="h-10 w-10 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Botón para crear usuario -->
    <div class="mb-4 flex justify-between items-center">
        @if(!$showForm)
            <button wire:click="create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                + Crear Nuevo Usuario
            </button>
        @endif
    </div>

    <!-- Formulario de creación/edición -->
    @if($showForm)
        <div class="bg-gray-100 p-6 rounded-lg mb-6">
            <h3 class="text-lg font-bold mb-4">{{ $editing ? 'Editar Usuario' : 'Crear Nuevo Usuario' }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre *</label>
                    <input type="text" wire:model="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email *</label>
                    <input type="email" wire:model="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('email') border-red-500 @enderror">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">{{ $editing ? 'Nueva Contraseña (opcional)' : 'Contraseña *' }}</label>
                    <input type="password" wire:model="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror">
                    @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Confirmar Contraseña</label>
                    <input type="password" wire:model="password_confirmation" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Tipo de Usuario *</label>
                    <select wire:model="user_type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('user_type') border-red-500 @enderror">
                        <option value="operator">Operador</option>
                        <option value="admin">Administrador</option>
                    </select>
                    @error('user_type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <div class="flex space-x-2 mt-4">
                <button wire:click="save" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    {{ $editing ? 'Actualizar' : 'Guardar' }}
                </button>
                <button wire:click="cancel" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    Cancelar
                </button>
            </div>
        </div>
    @endif

    <!-- Filtros de búsqueda -->
    <div class="mb-4 flex flex-wrap gap-2">
        <div class="flex-1">
            <input type="text" wire:model="search" placeholder="Buscar por nombre o email..." 
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        
        <select wire:model="filterType" class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <option value="">Todos los tipos</option>
            <option value="admin">Administradores</option>
            <option value="operator">Operadores</option>
        </select>
        
        <button wire:click="resetFilters" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
            Limpiar Filtros
        </button>
    </div>

    <!-- Tabla de usuarios -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded-lg overflow-hidden">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Registro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->user_type === 'admin')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                👑 Administrador
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                🔧 Operador
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <button wire:click="edit({{ $user->id }})" class="text-blue-600 hover:text-blue-900 mr-3">
                            <svg class="h-5 w-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Editar
                        </button>
                        <button wire:click="delete({{ $user->id }})" onclick="return confirm('¿Estás seguro de eliminar este usuario?')" class="text-red-600 hover:text-red-900">
                            <svg class="h-5 w-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Eliminar
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                        No se encontraron usuarios
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <!-- Estilos adicionales -->
    <style>
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-down {
            animation: fadeInDown 0.3s ease-out;
        }
    </style>
</div>