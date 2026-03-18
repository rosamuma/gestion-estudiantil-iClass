<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'phone', 'location', 'about'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isTeacher(): bool { return $this->role === 'teacher'; }
    public function isStudent(): bool { return $this->role === 'student'; }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin'   => 'Administrador',
            'teacher' => 'Docente',
            'student' => 'Estudiante',
            default   => 'Usuario',
        };
    }

    public function getRoleBadgeAttribute(): string
    {
        return match ($this->role) {
            'admin'   => 'danger',
            'teacher' => 'warning',
            'student' => 'success',
            default   => 'secondary',
        };
    }
}
