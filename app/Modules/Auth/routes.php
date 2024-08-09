<?php

use App\Modules\Auth\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('signup', [AuthController::class, 'signup']);
    Route::post('signin', [AuthController::class, 'signin']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});
