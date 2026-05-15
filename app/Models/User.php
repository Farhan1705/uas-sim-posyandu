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
        'role',
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

    public function pregnantWoman()
    {
        return $this->hasOne(PregnantWoman::class);
    }
    
    public function isBidan()
    {
        return $this->role === 'bidan';
    }
    
    public function isOrangTua()
    {
        return $this->role === 'orang_tua';
    }
}