<?php

namespace Bilalbaraz\LaravelKibana\Client;

use Bilalbaraz\LaravelKibana\Enums\EndpointEnums;

/**
 * Class KibanaSpace
 * @package Bilalbaraz\LaravelKibana\Client
 */
class KibanaSpace extends KibanaClient
{
    /**
     * @return array
     */
    public function getSpaces(): array
    {
        $spaces = $this->makeRequest($this->getKibanaBaseUrl() . EndpointEnums::GET_SPACES);

        return $this->toArray($spaces);
    }

    /**
     * @param string $spaceId
     * @return array
     */
    public function getSpace($spaceId): array
    {
        $spaces = $this->makeRequest($this->getKibanaBaseUrl() . EndpointEnums::GET_SPACES . '/' . $spaceId);

        return $this->toArray($spaces);
    }

    /**
     * @param array $space
     * @return array
     */
    public function createSpace($space = []): array
    {
        $spaces = $this->makeRequest($this->getKibanaBaseUrl() . EndpointEnums::GET_SPACES, 'POST', $space);

        return $this->toArray($spaces);
    }

    /**
     * @param string $spaceId
     * @param array $space
     * @return array
     */
    public function updateSpace($spaceId, $space = []): array
    {
        $space = $this->makeRequest(
            $this->getKibanaBaseUrl() . EndpointEnums::GET_SPACES . '/' . $spaceId, 'PUT', $space
        );

        return $this->toArray($space);
    }

    /**
     * @param string $spaceId
     * @return bool
     */
    public function deleteSpace($spaceId): bool
    {
        $this->makeRequest($this->getKibanaBaseUrl() . EndpointEnums::GET_SPACES . '/' . $spaceId, 'DELETE');

        return true;
    }
}
