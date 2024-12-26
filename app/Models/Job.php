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
        'is_recent',
        'requirements',
        'responsibilities',
        'location',
        'salary_range',
        'employment_type',
        'experience_level',
        'category',
        'tags',
        'posted_time',
    ];

    protected $casts = [
        'is_recent' => 'boolean',
        'requirements' => 'array',
        'responsibilities' => 'array',
        'tags' => 'array',
    ];

    public function employer()
    {
        return $this->belongsTo(Employee::class, 'employer_id');
    }

    public function appliedJobs()
    {
        return $this->hasMany(AppliedJob::class);
    }

    public function similarJobs()
    {
        return $this->hasMany(Job::class, 'category', 'category')->where('id', '!=', $this->id);
    }

    public function featuredJobs()
    {
        return $this->hasMany(Job::class, 'employer_id', 'employer_id')->where('id', '!=', $this->id);
    }
}
