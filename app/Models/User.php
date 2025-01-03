<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'country',
        'job_title',
        'newsletter',
        'terms',
        'role',
        'is_verified',
        'photo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'id' => 'string',
        'is_verified' => 'boolean',
        'newsletter' => 'boolean',
        'terms' => 'boolean',
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

    public function getAuthPassword()
    {
        return $this->password;
    }
 
    public function passwordNeedsRehash()
    {
        return Hash::needsRehash($this->password);
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


    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function isEmployee()
    {
        return $this->role === 'employee';
    }

    public function isJobSeeker()
    {
        return $this->role === 'job_seeker';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function hasVerifiedEmail()
    {
        return $this->is_verified;
    }


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'is_verified' => true,
        ])->save();
    }
}
