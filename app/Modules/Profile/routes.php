<?php

use App\Modules\Profile\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::patch('/profile', [ProfileController::class, 'updateProfile']);
});