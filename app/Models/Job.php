<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id', 'title', 'description', 'location', 'salary'
    ];

    public function employer()
    {
        return $this->belongsTo(Employee::class, 'employer_id');
    }

    public function appliedJobs()
    {
        return $this->hasMany(AppliedJob::class, 'job_id');
    }
}
