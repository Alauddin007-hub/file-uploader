<?php

namespace App\Providers;

use App\Models\File;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;

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
    public function boot(): void
    {
        Route::bind('file', function ($value) {
            return File::where('unique_id', $value)->firstOrFail();
        });
    
        Inertia::share([
            // Share any data that should be available to all Inertia views
        ]);
    }
}
