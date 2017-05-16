<?php namespace Jackiedo\Timezonelist;

use Illuminate\Support\ServiceProvider;

/**
 * TimezonelistServiceProvider
 *
 * @package    jackiedo/timezonelist
 * @author     Jackie Do <anhvudo@gmail.com>
 * @copyright  2015 Jackie Do
 */

class TimezonelistServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('jackiedo/timezonelist');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['timezonelist'] = $this->app->share(function ($app) {
            return new Timezonelist;
        });

        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
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
}
