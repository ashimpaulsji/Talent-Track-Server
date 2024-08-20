<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    // Remove these lines as we're now using standard incrementing IDs
    // protected $keyType = 'string';
    // public $incrementing = false;

    protected $fillable = [
        'employer_id',
        'title',
        'description',
        'location',
        'salary',
    ];

    public function employer()
    {
        return $this->belongsTo(Employee::class, 'employer_id');
    }
}