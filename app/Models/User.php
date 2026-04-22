<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $fillable = [
        'name', 'email', 'password', 'employee_id',
        'department', 'designation', 'signature_path', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    public function events()
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'issued_by');
    }

    public function getRoleNameAttribute(): string
    {
        return $this->roles->first()?->name ?? 'N/A';
    }
}
