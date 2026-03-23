{{-- resources/views/livewire/admin/user-management.blade.php --}}
<div>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Gestión de Usuarios</h1>
            <a href="{{ route('admin.users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Crear Usuario
            </a>
        </div>
        
        <!-- Mensajes -->
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
        
        <!-- Filtros -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input type="text" wire:model="search" placeholder="Nombre o email..." 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                    <select wire:model="filterType" class="w-full rounded-md border-gray-300">
                        <option value="todos">Todos</option>
                        <option value="admin">Administradores</option>
                        <option value="employee">Empleados</option>
                        <option value="user">Usuarios</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select wire:model="filterStatus" class="w-full rounded-md border-gray-300">
                        <option value="todos">Todos</option>
                        <option value="active">Activos</option>
                        <option value="inactive">Inactivos</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button wire:click="resetFilters" class="text-sm text-gray-600 hover:text-gray-900">
                        Limpiar filtros
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Tabla de usuarios -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Usuario</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full" src="{{ $user->profile_photo_url }}" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->user_type == 'admin' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $user->user_type == 'employee' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $user->user_type == 'user' ? 'bg-green-100 text-green-800' : '' }}">
                                {{ ucfirst($user->user_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Editar</a>
                            
                            @if($user->is_active)
                                @if($user->id !== auth()->id())
                                    <button wire:click="disableUser({{ $user->id }})" class="text-red-600 hover:text-red-900">
                                        Deshabilitar
                                    </button>
                                @endif
                            @else
                                <button wire:click="enableUser({{ $user->id }})" class="text-green-600 hover:text-green-900">
                                    Habilitar
                                </button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="px-6 py-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
