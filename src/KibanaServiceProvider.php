<?php

namespace Bilalbaraz\LaravelKibana;

use Bilalbaraz\LaravelKibana\Client\Kibana;
use GuzzleHttp\Client;
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
        $this->app->singleton(Kibana::class, function ($app) {
            return new Kibana(new Client(), $app['config']['kibana']);
        });

        $this->mergeConfigFrom(__DIR__ . '/../config/kibana.php', 'config');
    }

    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../config/kibana.php' => config_path('kibana.php')], 'config');
    }

    /**
     * @return array
     */
    public function provides(): array
    {
        return [Kibana::class];
    }
}
