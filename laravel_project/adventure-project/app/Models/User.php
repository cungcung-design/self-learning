<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Add role here
    ];

    // Set default values for model attributes
    protected $attributes = [
        'role' => 'user',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Helper methods for roles
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }
}