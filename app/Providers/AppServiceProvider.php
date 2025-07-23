<?php

namespace App\Providers;

use App\Models\Specialty; // Add this import
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View; // Add this import

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->runningInConsole() && !$this->app->runningUnitTests()) {
            $this->app->instance('middleware.disable', true);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });

        // Improved View Composer
        View::composer('client.dashboard', function ($view) {
            $specialties = Specialty::where('is_active', true)->get();
            
            $view->with([
                'domains' => $specialties->take(10),
                'secteurs' => $specialties->slice(10)->take(10),
                // Add any other shared data here
            ]);
        });
    }
}