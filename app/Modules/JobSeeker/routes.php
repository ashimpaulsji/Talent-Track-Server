<?php

use Illuminate\Support\Facades\Route;
use App\Modules\JobSeeker\Controllers\JobSeekerController;

Route::group(['prefix' => 'job-seeker', 'middleware' => ['auth:api']], function () {
    Route::post('/profile', [JobSeekerController::class, 'createProfile']);
    Route::put('/profile', [JobSeekerController::class, 'updateProfile']);
    Route::get('/jobs/search', [JobSeekerController::class, 'searchJobs']);
    Route::post('/jobs/{jobId}/save', [JobSeekerController::class, 'saveJob']);
    Route::get('/saved-jobs', [JobSeekerController::class, 'getSavedJobs']);
    Route::post('/jobs/{jobId}/apply', [JobSeekerController::class, 'applyForJob']);
    Route::get('/applications', [JobSeekerController::class, 'getApplicationStatus']);
});
