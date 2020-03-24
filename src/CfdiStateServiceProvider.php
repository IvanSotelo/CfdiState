<?php

namespace IvanSotelo\CfdiState;

use Illuminate\Support\ServiceProvider;

class CfdiStateServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/cfdi-state.php' => config_path('cfdi-state.php')
        ], 'config');

        // $this->publishes([
        //     __DIR__.'/migrations' => database_path('migrations')
        // ], 'migrations');

        $this->loadTranslations();

    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/cfdi-state.php', 'cfdi-state');
    }

    protected function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/lang', 'ivansotelo');

        /*$this->publishes([
            __DIR__.'/translations' => resource_path('lang/vendor/courier'),
        ]);*/
    }
}
