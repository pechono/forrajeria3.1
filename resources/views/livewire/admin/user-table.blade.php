{{-- resources/views/livewire/admin/user-table.blade.php --}}

<div>
    <!-- Mensajes de notificación -->
    @if (session()->has('message'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <span class="text-green-700">&times;</span>
            </button>
        </div>
    @endif
    
    @if (session()->has('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
            <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.style.display='none'">
                <span class="text-red-700">&times;</span>
            </button>
        </div>
    @endif

    <!-- Filtros y búsqueda -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Buscador -->
            <div class="col-span-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Buscar</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" 
                           wire:model="search" 
                           placeholder="Buscar por nombre o email..."
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
            </div>
            
            <!-- Filtro por tipo -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de usuario</label>
                <select wire:model="filterType" 
                        class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="todos">Todos</option>
                    <option value="admin">Administradores</option>
                    <option value="employee">Empleados</option>
                    <option value="user">Usuarios normales</option>
                </select>
            </div>
            
            <!-- Filtro por estado -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                <select wire:model="filterStatus" 
                        class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                    <option value="todos">Todos</option>
                    <option value="active">Activos</option>
                    <option value="inactive">Inactivos</option>
                </select>
            </div>
            
            <!-- Botón limpiar filtros -->
            <div class="flex items-end">
                <button wire:click="resetFilters" 
                        class="w-full md:w-auto px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                    Limpiar filtros
                </button>
            </div>
        </div>
        
        <!-- Resultados de búsqueda -->
        <div class="mt-3 text-sm text-gray-600">
            Mostrando {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} de {{ $users->total() }} usuarios
        </div>
    </div>

    <!-- Tabla de usuarios -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Usuario
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Verificación
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha registro
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                            <!-- Usuario con foto -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($user->profile_photo_path)
                                            <img class="h-10 w-10 rounded-full object-cover" src="{{ Storage::url($user->profile_photo_path) }}" alt="{{ $user->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center">
                                                <span class="text-white text-sm font-medium">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                                <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    Tú
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Email -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            </td>
                            
                            <!-- Tipo de usuario con colores -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $typeColors = [
                                        'admin' => 'bg-red-100 text-red-800',
                                        'employee' => 'bg-yellow-100 text-yellow-800',
                                        'user' => 'bg-green-100 text-green-800'
                                    ];
                                    $typeLabels = [
                                        'admin' => 'Administrador',
                                        'employee' => 'Empleado',
                                        'user' => 'Usuario'
                                    ];
                                    $typeColor = $typeColors[$user->user_type] ?? 'bg-gray-100 text-gray-800';
                                    $typeLabel = $typeLabels[$user->user_type] ?? ucfirst($user->user_type);
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $typeColor }}">
                                    {{ $typeLabel }}
                                </span>
                            </td>
                            
                            <!-- Estado con badge interactivo -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->is_active)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        <svg class="mr-1 h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Activo
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        <svg class="mr-1 h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Verificación de email -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->email_verified_at)
                                    <span class="text-xs text-green-600 flex items-center">
                                        <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $user->email_verified_at->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="text-xs text-red-600 flex items-center">
                                        <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        No verificado
                                    </span>
                                @endif
                            </td>
                            
                            <!-- Fecha registro -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('d/m/Y H:i') }}
                            </td>
                            
                            <!-- Acciones -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <!-- Botón editar -->
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 transition duration-150 ease-in-out"
                                       title="Editar usuario">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    
                                    <!-- Botón habilitar/deshabilitar -->
                                    @if($user->id !== auth()->id())
                                        @if($user->is_active)
                                            <button wire:click="disableUser({{ $user->id }})" 
                                                    wire:confirm="¿Estás seguro de que deseas deshabilitar a {{ $user->name }}? Este usuario no podrá iniciar sesión."
                                                    class="text-red-600 hover:text-red-900 transition duration-150 ease-in-out"
                                                    title="Deshabilitar usuario">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                </svg>
                                            </button>
                                        @else
                                            <button wire:click="enableUser({{ $user->id }})" 
                                                    wire:confirm="¿Estás seguro de que deseas habilitar a {{ $user->name }}?"
                                                    class="text-green-600 hover:text-green-900 transition duration-150 ease-in-out"
                                                    title="Habilitar usuario">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <p class="text-gray-500 text-lg">No se encontraron usuarios</p>
                                    <p class="text-gray-400 text-sm mt-1">Intenta con otros filtros o crea un nuevo usuario</p>
                                    <a href="{{ route('admin.users.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        Crear nuevo usuario
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Paginación -->
        @if($users->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $users->links() }}
            </div>
        @endif
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
