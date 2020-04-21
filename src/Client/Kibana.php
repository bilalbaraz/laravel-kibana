<?php

namespace Bilalbaraz\LaravelKibana\Client;

/**
 * Class Kibana
 * @package Bilalbaraz\LaravelKibana\Client
 */
class Kibana
{
    /**
     * @return array
     */
    public function getConfig(): array
    {
        return config('kibana');
    }
}
