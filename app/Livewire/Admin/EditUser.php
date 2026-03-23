<?php
// app/Livewire/Admin/EditUser.php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Rules\Password;

class EditUser extends Component
{
    public $user;
    public $userId;
    public $name;
    public $email;
    public $user_type;
    public $is_active;
    public $password;
    public $password_confirmation;
    public $updatePassword = false;
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'user_type' => 'required|in:admin,employee,user',
        'is_active' => 'boolean',
    ];
    
    protected function rulesWithPassword()
    {
        return array_merge($this->rules, [
            'password' => ['required', 'string', new Password, 'confirmed'],
        ]);
    }
    
   public function mount($user)
{
    // Verificar permisos
    if (!Auth::user()->isAdmin()) {
        abort(403, 'No tienes permisos para editar usuarios.');
    }
    
    // No permitir que un admin modifique su propio tipo de usuario a no-admin
    if ($user->id === Auth::id()) {
        $this->isSelf = true;
    }
    
    $this->user = $user;
    $this->userId = $user->id;
    $this->name = $user->name;
    $this->email = $user->email;
    $this->user_type = $user->user_type;
    $this->is_active = $user->is_active;
}
    
    public function updated($propertyName)
    {
        if ($this->updatePassword) {
            $this->validateOnly($propertyName, $this->rulesWithPassword());
        } else {
            $this->validateOnly($propertyName, $this->rules);
        }
        
        // Validación especial para email único excepto el usuario actual
        if ($propertyName === 'email') {
            $this->validateOnly('email', [
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($this->userId),
                ]
            ]);
        }
    }
    
    public function updateUser()
    {
        // Validar según si se actualiza contraseña o no
        if ($this->updatePassword) {
            $this->validate($this->rulesWithPassword());
        } else {
            $this->validate($this->rules);
            
            // Validación adicional para email único
            $this->validate([
                'email' => Rule::unique('users')->ignore($this->userId),
            ]);
        }
        
        // Preparar datos para actualizar
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'user_type' => $this->user_type,
            'is_active' => $this->is_active,
        ];
        
        // Si se actualiza contraseña
        if ($this->updatePassword && $this->password) {
            $data['password'] = Hash::make($this->password);
        }
        
        // Actualizar usuario
        $this->user->update($data);
        
        // Mensaje de éxito
        session()->flash('message', 'Usuario actualizado correctamente.');
        
        // Limpiar campos de contraseña si se usaron
        if ($this->updatePassword) {
            $this->reset(['password', 'password_confirmation']);
            $this->updatePassword = false;
        }
        
        // Redirigir o mantener en la página
        return redirect()->route('admin.users');
    }
    
    public function cancel()
    {
        return redirect()->route('admin.users');
    }
    
    public function render()
    {
        return view('livewire.admin.edit-user')
            ->layout('layouts.app');
    }
}
