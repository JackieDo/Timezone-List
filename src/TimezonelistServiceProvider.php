<?php

namespace Jackiedo\Timezonelist;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

/**
 * TimezonelistServiceProvider.
 *
 * @package Jackiedo\Timezonelist
 *
 * @author Jackie Do <anhvudo@gmail.com>
 */
class TimezonelistServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('timezonelist', function ($app) {
            return new Timezonelist;
        });

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Timezonelist', 'Jackiedo\Timezonelist\Facades\Timezonelist');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['timezonelist'];
    }

    /**
     * Determine if the provider is deferred.
     *
     * @return bool
     */
    public function isDeferred()
    {
        return false;
    }
}
