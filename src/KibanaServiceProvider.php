<?php

namespace Bilalbaraz\LaravelKibana;

use Illuminate\Support\ServiceProvider;

/**
 * Class KibanaServiceProvider
 * @package Bilalbaraz\LaravelKibana
 */
class KibanaServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/kibana.php', 'config');
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/kibana.php' => config_path('kibana.php')], 'config');
    }
}
