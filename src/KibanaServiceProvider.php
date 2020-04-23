<?php

namespace Bilalbaraz\LaravelKibana;

use Bilalbaraz\LaravelKibana\Client\KibanaObject;
use Bilalbaraz\LaravelKibana\Client\KibanaSpace;
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
        $client = new Client();

        $this->app->singleton(KibanaSpace::class, function ($app) use ($client) {
            return new KibanaSpace($client, $app['config']['kibana']);
        });

        $this->app->singleton(KibanaObject::class, function ($app) use ($client) {
            return new KibanaObject($client, $app['config']['kibana']);
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
        return [KibanaSpace::class];
    }
}
