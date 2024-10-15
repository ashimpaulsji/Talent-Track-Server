<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    require base_path('app/Modules/Auth/routes.php');
    require base_path('app/Modules/User/routes.php');
    require base_path('app/Modules/Employer/routes.php');
    require base_path('app/Modules/JobSeeker/routes.php');
});
