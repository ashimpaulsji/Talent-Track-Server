<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'username', 
        'name',
        'email', 
        'password', 
        'is_verified', 
        'photo', 
        'role'
    ];

    protected $casts = [
        'id' => 'string',
        'is_verified' => 'boolean',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}