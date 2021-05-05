<?php

namespace Ntpages\LaravelEncore;

use Illuminate\Support\ServiceProvider;

class EncoreServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                dirname(__DIR__) . '/config/encore.php' => config_path('encore.php')
            ], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(dirname(__DIR__) . '/config/encore.php', 'encore');

        $this->app->singleton(Encore::class, fn() => new Encore());
    }
}
