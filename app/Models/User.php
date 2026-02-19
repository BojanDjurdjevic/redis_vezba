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

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    const ROLE_CLIENT = 'client';
    const ROLE_ADMINISTRATOR = 'administrator';
    const ROLE_TRUCKER = 'trucker';

    const ALLOWED_ROLES = [
        self::ROLE_CLIENT, self::ROLE_ADMINISTRATOR, self::ROLE_TRUCKER
    ];
    
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function setRoleAttribute(string $role)
    {
        if(!in_array($role, self::ALLOWED_ROLES))
        {
            throw new \Exception('Invalid role!');
        }    

        $this->attributes['role'] = $role;
    }
}
