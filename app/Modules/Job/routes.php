<?php

use App\Modules\Job\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'jobs', 'middleware' => ['auth:api']], function () {
    Route::post('/', [JobController::class, 'create']);
    Route::put('/{jobId}', [JobController::class, 'update']);
    Route::delete('/{jobId}', [JobController::class, 'delete']);
    Route::get('/', [JobController::class, 'list']);
    Route::get('/{jobId}', [JobController::class, 'get']);
});
