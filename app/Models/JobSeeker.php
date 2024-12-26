<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSeeker extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'resume',
        'skills',
        'experience',
    ];

    protected $casts = [
        'skills' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appliedJobs()
    {
        return $this->hasMany(AppliedJob::class);
    }

    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class);
    }
}
