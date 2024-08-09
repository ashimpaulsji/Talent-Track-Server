<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'username',
        'email',
        'password',
        'is_verified',
        'photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function jobSeeker()
    {
        return $this->hasOne(JobSeeker::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
