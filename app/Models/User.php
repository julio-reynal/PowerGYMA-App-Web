<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'expires_at',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'expires_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Normalizar el rol a minúsculas al asignarlo.
     */
    public function setRoleAttribute($value): void
    {
        $this->attributes['role'] = is_string($value) ? strtolower($value) : $value;
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function isAdmin(): bool
    {
    return strtolower((string)$this->role) === 'admin';
    }

    /**
     * Verificar si el usuario es cliente
     */
    public function isCliente(): bool
    {
    return strtolower((string)$this->role) === 'cliente';
    }

    /**
     * Verificar si el usuario es demo
     */
    public function isDemo(): bool
    {
    return strtolower((string)$this->role) === 'demo';
    }

    /**
     * Verificar si el usuario está activo y no ha expirado
     */
    public function isActiveAndNotExpired(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Scope para usuarios activos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }
}
