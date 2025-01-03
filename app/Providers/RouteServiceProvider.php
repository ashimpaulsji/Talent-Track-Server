<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        parent::boot();
    }

    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(function () {
                 // Replace the apiRecurse function call with your desired logic
                 // For example, you can use a loop to iterate through the files in the directory
                 $modulesPath = base_path('/app/Modules');
                 $files = scandir($modulesPath);
                 foreach ($files as $file) {
                     // Your logic here
                 }
             });
    }

    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }
}
