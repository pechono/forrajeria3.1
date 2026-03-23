<?php
// app/Livewire/Admin/CreateUser.php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\Facades\Auth;

class CreateUser extends Component
{
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $user_type = 'user';
    public $is_active = true;
    
    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|confirmed',
        'user_type' => 'required|in:admin,employee,user',
        'is_active' => 'boolean',
    ];
    
    public function mount()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'No tienes permisos para crear usuarios.');
        }
    }
    
    public function createUser()
    {
        $this->validate();
        
        $createUser = new CreateNewUser();
        
        $user = $createUser->create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'user_type' => $this->user_type,
        ]);
        
        // Actualizar el estado activo si es necesario
        if (!$this->is_active) {
            $user->update(['is_active' => false]);
        }
        
        session()->flash('message', "Usuario {$user->name} creado exitosamente.");
        $this->reset(['name', 'email', 'password', 'password_confirmation']);
        
        return redirect()->route('admin.users');
    }
    
    public function render()
    {
        return view('livewire.admin.create-user')
            ->layout('layouts.app');
    }
}