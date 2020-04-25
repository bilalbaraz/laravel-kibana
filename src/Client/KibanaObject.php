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
     * @param string $objectType
     * @param string $objectId
     * @return array
     */
    public function getSavedObject($objectType, $objectId): array
    {
        $objects = $this->makeRequest(
            $this->getKibanaBaseUrl() . EndpointEnums::GET_SAVED_OBJECTS . '/' . $objectType . '/' . $objectId
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

    /**
     * @param string $objectType
     * @return array
     */
    public function findObjects($objectType): array
    {
        $objects = $this->makeRequest($this->getKibanaBaseUrl() . EndpointEnums::FIND_OBJECTS . '?type=' . $objectType);

        return $this->toArray($objects);
    }

    /**
     * @param array $objects
     * @return array
     */
    public function exportObjects(array $objects = [])
    {
        $exportedObjects = $this->makeRequest($this->getKibanaBaseUrl() . EndpointEnums::EXPORT_OBJECTS,
            'POST',
            $objects,
            true
        );

        $result = [];
        $objectElements = explode(PHP_EOL, $exportedObjects);

        foreach ($objectElements as $element) {
            $result[] = $this->toArray($element);
        }

        return $result;
    }

    /**
     * @param string $objectType
     * @param string $objectId
     * @return array
     */
    public function deleteObject(string $objectType, string $objectId): array
    {
        $dashboard = $this->makeRequest(
            $this->getKibanaBaseUrl() . EndpointEnums::GET_SAVED_OBJECTS . '/' . $objectType . '/' . $objectId,
            'DELETE'
        );

        return $this->toArray($dashboard);
    }
}
