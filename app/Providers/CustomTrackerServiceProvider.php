<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use PragmaRX\Tracker\Vendor\Laravel\ServiceProvider as TrackerServiceProvider

class CustomTrackerServiceProvider extends TrackerServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
