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
     * @param array $objects
     * @return array
     */
    public function getBulkObjects(array $objects = []): array
    {
        $objects = $this->makeRequest(
            $this->getKibanaBaseUrl() . EndpointEnums::GET_BULK_OBJECTS, 'POST',
            $objects,
            true
        );

        return $this->toArray($objects);
    }
}
