<?php

use App\Modules\User\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::get('/users/{id}', [UserController::class, 'getUser']);
    Route::put('/users/{id}', [UserController::class, 'updateUser']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
});