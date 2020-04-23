<?php

namespace Bilalbaraz\LaravelKibana\Client;

use Bilalbaraz\LaravelKibana\Enums\EndpointEnums;

/**
 * Class KibanaFeature
 * @package Bilalbaraz\LaravelKibana\Client
 */
class KibanaFeature extends KibanaClient
{
    /**
     * @return array
     */
    public function getFeatures(): array
    {
        $features = $this->makeRequest($this->getKibanaBaseUrl() . EndpointEnums::GET_FEATURES);

        return $this->toArray($features);
    }
}
