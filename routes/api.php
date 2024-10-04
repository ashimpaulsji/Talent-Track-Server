<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Include the routes for your modules
    require base_path('app/Modules/Auth/routes.php');
    require base_path('app/Modules/User/routes.php');
    require base_path('app/Modules/Employer/routes.php');
});

 