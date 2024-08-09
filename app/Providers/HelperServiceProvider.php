<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 *
 */
class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        if (glob(app_path() . '/Helpers/*.php') !== false)
        foreach (glob(app_path() . '/Helpers/*.php') as $filename) {
            require_once($filename);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
