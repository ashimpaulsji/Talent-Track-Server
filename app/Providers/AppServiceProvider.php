<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    // {
    //     //
    // }

    public function boot()
   {
       Log::info('Database Config:', [
           'host' => config('database.connections.pgsql.host'),
           'port' => config('database.connections.pgsql.port'),
           'database' => config('database.connections.pgsql.database'),
           'username' => config('database.connections.pgsql.username'),
       ]);
   }
}
