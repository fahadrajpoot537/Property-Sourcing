<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        \App\Models\AvailableProperty::observe(\App\Observers\AvailablePropertyObserver::class);

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('services')) {
                // Sharing services variable for the navbar dropdown
                view()->share('services_shared', \App\Models\Service::all());
            }
        } catch (\Exception $e) {
            // handle migration edge cases or empty database
        }
    }
}
