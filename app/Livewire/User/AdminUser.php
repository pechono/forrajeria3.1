<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;

class AdminUser extends Component
{
    use WithPagination;
    
    // Propiedades para el formulario
    public $showForm = false;
    public $editing = false;
    public $userId;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $user_type = 'operator';
    
    // Propiedades para búsqueda y filtros
    public $search = '';
    public $filterType = '';
    
    // Propiedades para mensajes
    public $message = '';
    public $messageType = '';
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'user_type' => 'required|in:admin,operator',
    ];
    
    public function render()
    {
        $query = User::query();
        
        // Aplicar búsqueda
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }
        
        // Aplicar filtro por tipo
        if ($this->filterType) {
            $query->where('user_type', $this->filterType);
        }
        
        $users = $query->orderBy('id', 'desc')->paginate(10);
        
        return view('livewire.user.admin-user', [
            'users' => $users,
            'adminCount' => User::where('user_type', 'admin')->count(),
            'operatorCount' => User::where('user_type', 'operator')->count(),
            'totalCount' => User::count(),
        ]);
    }
    
    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editing = false;
        $this->resetValidation();
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->user_type = $user->user_type;
        $this->editing = true;
        $this->showForm = true;
        $this->resetValidation();
    }
    
    public function save()
    {
        // Validar según sea creación o edición
        if ($this->editing) {
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $this->userId,
                'user_type' => 'required|in:admin,operator',
            ];
            
            if (!empty($this->password)) {
                $rules['password'] = 'required|min:6|confirmed';
            }
            
            $this->validate($rules);
        } else {
            $this->validate($this->rules);
        }
        
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'user_type' => $this->user_type,
        ];
        
        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }
        
        try {
            if ($this->editing) {
                $user = User::find($this->userId);
                $user->update($data);
                $this->showMessage('Usuario actualizado exitosamente.', 'success');
            } else {
                $data['password'] = Hash::make($this->password);
                User::create($data);
                $this->showMessage('Usuario creado exitosamente.', 'success');
            }
            
            $this->resetForm();
            $this->showForm = false;
            
        } catch (\Exception $e) {
            $this->showMessage('Error al guardar el usuario: ' . $e->getMessage(), 'error');
        }
    }
    
    public function delete($id)
    {
        $user = User::find($id);
        
        // No permitir eliminar a sí mismo
        if ($user->id === auth()->id()) {
            $this->showMessage('No puedes eliminar tu propio usuario.', 'error');
            return;
        }
        
        // No eliminar el último administrador
        $adminCount = User::where('user_type', 'admin')->count();
        if ($user->user_type === 'admin' && $adminCount <= 1) {
            $this->showMessage('No puedes eliminar el único administrador del sistema.', 'error');
            return;
        }
        
        try {
            $user->delete();
            $this->showMessage('Usuario eliminado exitosamente.', 'success');
        } catch (\Exception $e) {
            $this->showMessage('Error al eliminar el usuario.', 'error');
        }
    }
    
    public function cancel()
    {
        $this->resetForm();
        $this->showForm = false;
        $this->resetValidation();
    }
    
    public function resetFilters()
    {
        $this->search = '';
        $this->filterType = '';
        $this->resetPage();
    }
    
    private function resetForm()
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation', 'user_type', 'userId', 'editing']);
        $this->resetValidation();
    }
    
    private function showMessage($message, $type)
    {
        $this->message = $message;
        $this->messageType = $type;
        
        // Limpiar mensaje después de 5 segundos
        $this->dispatch('clearMessage');
    }
    
    public function clearMessage()
    {
        $this->message = '';
        $this->messageType = '';
    }
    
    // Actualizar la paginación cuando se busca
    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function updatingFilterType()
    {
        $this->resetPage();
    }
}