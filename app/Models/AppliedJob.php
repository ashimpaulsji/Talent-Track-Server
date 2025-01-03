<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppliedJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id',
        'job_seeker_id',
        'application_date',
    ];

    protected $casts = [
        'application_date' => 'datetime',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function jobSeeker()
    {
        return $this->belongsTo(JobSeeker::class);
    }
}