<?php

namespace Damilare\LaravelHelperMacros;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class HelperMacroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Collection::make(glob(__DIR__ . '/Macros/*.php'))
            ->mapWithKeys(function ($path) {
                return [$path => pathinfo($path, PATHINFO_FILENAME)];
            })
            ->each(function ($macro, $path) {
                require_once $path;
            });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
