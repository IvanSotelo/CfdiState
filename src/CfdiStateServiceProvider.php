<?php

namespace IvanSotelo\CfdiState;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Support\Facades\Event;

class CfdiStateServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->publishes([
        //     __DIR__.'/config/fire.php' => config_path('fire.php')
        // ], 'config');

        // $this->publishes([
        //     __DIR__.'/migrations' => database_path('migrations')
        // ], 'migrations');

        // $this->loadTranslationsFrom(__DIR__.'/lang', 'krnos');

        // $this->publishes([
        //     __DIR__.'/lang' => resource_path('lang/vendor/krnos'),
        // ], 'translations');

        // Event::subscribe(Listeners\FireEventSubscriber::class);
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        // $this->mergeConfigFrom(__DIR__ . '/config/fire.php', 'fire');
    }
}
