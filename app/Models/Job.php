<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'title',
        'description',
        'requirements',
        'responsibilities',
        'location',
        'salary_range',
        'employment_type',
        'experience_level',
    ];

    public function employer()
    {
        return $this->belongsTo(Employee::class, 'employer_id');
    }

    public function appliedJobs()
    {
        return $this->hasMany(AppliedJob::class);
    }
}
