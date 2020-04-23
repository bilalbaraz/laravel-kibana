<?php

namespace Bilalbaraz\LaravelKibana\Client;

use Bilalbaraz\LaravelKibana\Enums\EndpointEnums;

/**
 * Class KibanaObject
 * @package Bilalbaraz\LaravelKibana\Client
 */
class KibanaObject extends KibanaClient
{
    /**
     * @param string $type
     * @param string $objectId
     * @return array
     */
    public function getSavedObject($type, $objectId): array
    {
        $objects = $this->makeRequest(
            $this->getKibanaBaseUrl() . EndpointEnums::GET_SAVED_OBJECTS . '/' . $type . '/' . $objectId
        );

        return $this->toArray($objects);
    }

    /**
     * @return array
     */
    public function getBulkObjects(): array
    {
        $objects = $this->makeRequest(
            $this->getKibanaBaseUrl() . EndpointEnums::GET_BULK_OBJECTS,
            'POST',
            [
                ['type' => 'index-pattern', 'id' => 'my-pattern'],
                ['type' => 'dashboard', 'id' => 'be3733a0-9efe-11e7-acb3-3dab96693fab'],
            ],
            true
        );

        return $this->toArray($objects);
    }
}
