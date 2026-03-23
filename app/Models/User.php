<?php
// app/Models/User.php

namespace App\Models;

use Laravel\Jetstream\HasTeams;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'is_active',        // Nuevo campo para deshabilitar
        'current_team_id',
        'profile_photo_path',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
    ];

    /**
     * Verificar si es administrador
     */
    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }

    /**
     * Verificar si el usuario está activo
     */
    public function isActive(): bool
    {
        return $this->is_active ?? true;
    }

    /**
     * Deshabilitar usuario
     */
    public function disable(): void
    {
        $this->update(['is_active' => false]);
    }

    /**
     * Habilitar usuario
     */
    public function enable(): void
    {
        $this->update(['is_active' => true]);
    }
}