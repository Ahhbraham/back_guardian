<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Log;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_photo',
        'role_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin(): bool
    {
        // Debugging log
        Log::info('isAdmin check:', [
            'user_id' => $this->id,
            'role_id' => $this->role_id,
            'is_admin' => $this->role_id === 5
        ]);

        return $this->role_id === 5; // Admin role ID is 5 as per roles table seeding
    }

    public function abilities()
    {
        // Simplified abilities based on role
        return [
            'view-dashboard' => $this->role_id !== 1, // User role (ID 1) can't view dashboard
            'manage-users' => $this->isAdmin(),
            'update-users' => $this->isAdmin(),
        ];
    }
}