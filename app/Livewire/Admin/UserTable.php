<?php
// app/Livewire/Admin/UserTable.php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserTable extends Component
{
    use WithPagination;

    public $search = '';
    public $filterType = 'todos';
    public $filterStatus = 'todos';
    
    protected $queryString = ['search', 'filterType', 'filterStatus'];
    
    public function disableUser($userId)
    {
        $user = User::find($userId);
        
        if ($user->id === Auth::id()) {
            session()->flash('error', 'No puedes deshabilitar tu propio usuario.');
            return;
        }
        
        $user->disable();
        session()->flash('message', "Usuario {$user->name} deshabilitado.");
    }
    
    public function enableUser($userId)
    {
        $user = User::find($userId);
        $user->enable();
        session()->flash('message', "Usuario {$user->name} habilitado.");
    }
    
    public function resetFilters()
    {
        $this->search = '';
        $this->filterType = 'todos';
        $this->filterStatus = 'todos';
    }
    
    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterType !== 'todos', function ($query) {
                $query->where('user_type', $this->filterType);
            })
            ->when($this->filterStatus !== 'todos', function ($query) {
                if ($this->filterStatus === 'active') {
                    $query->where('is_active', true);
                } elseif ($this->filterStatus === 'inactive') {
                    $query->where('is_active', false);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('livewire.admin.user-table', [
            'users' => $users
        ]);
    }
}