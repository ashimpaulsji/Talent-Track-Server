<?php

use App\Modules\Employer\Controllers\EmployerController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'employer', 'middleware' => ['auth:api']], function () {
    Route::post('/profile', [EmployerController::class, 'createOrUpdateCompanyProfile']);
    Route::get('/profile', [EmployerController::class, 'getCompanyProfile']);
});
