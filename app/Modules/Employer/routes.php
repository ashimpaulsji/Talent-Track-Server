<?php

use App\Modules\Employer\Controllers\EmployerController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'employer', 'middleware' => ['auth:api']], function () {
    Route::post('/profile', [EmployerController::class, 'createOrUpdateCompanyProfile']);
    Route::get('/profile', [EmployerController::class, 'getCompanyProfile']);
    Route::post('/jobs', [EmployerController::class, 'postJob']);
    Route::put('/jobs/{jobId}', [EmployerController::class, 'updateJob']);
    Route::delete('/jobs/{jobId}', [EmployerController::class, 'deleteJob']);
    Route::get('/jobs', [EmployerController::class, 'getJobs']);
    Route::get('/jobs/{jobId}', [EmployerController::class, 'getJob']);
});
