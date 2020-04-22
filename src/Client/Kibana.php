<?php

namespace Bilalbaraz\LaravelKibana\Client;

use Bilalbaraz\LaravelKibana\Enums\EndpointEnums;
use GuzzleHttp\Client;

/**
 * Class Kibana
 * @package Bilalbaraz\LaravelKibana\Client
 */
class Kibana
{
    private $client;
    private $config;

    /**
     * Kibana constructor.
     * @param Client $client
     * @param array $config
     */
    public function __construct(Client $client, array $config = [])
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @return array
     */
    public function getFeatures(): array
    {
        $features = $this->makeRequest($this->getKibanaBaseUrl() . EndpointEnums::GET_FEATURES);

        return $this->toArray($features);
    }

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
     * @param string $endpoint
     * @param string $method
     * @param array $body
     * @return string
     */
    public function makeRequest($endpoint, $method = 'GET', $body = []): string
    {
        return $this->client->request(
            $method,
            $endpoint,
            ['headers' => ['kbn-xsrf' => true], 'form_params' => $body]
        )
            ->getBody()
            ->getContents();
    }

    /**
     * @return string
     */
    public function getKibanaBaseUrl(): string
    {
        return $this->config['host'] . ':' . $this->config['port'] . '/' . EndpointEnums::API . '/';
    }

    /**
     * @param string $json
     * @return array
     */
    public function toArray($json)
    {
        return json_decode($json, true);
    }
}
