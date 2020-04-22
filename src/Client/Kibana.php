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
        $features = $this->makeRequest(
            $this->getKibanaBaseUrl() . '/' . EndpointEnums::API . '/' . EndpointEnums::GET_FEATURES
        );

        return $this->toArray($features);
    }

    /**
     * @param string $endpoint
     * @param string $method
     * @return string
     */
    public function makeRequest($endpoint, $method = 'GET'): string
    {
        return $this->client->request($method, $endpoint)->getBody()->getContents();
    }

    /**
     * @return string
     */
    public function getKibanaBaseUrl(): string
    {
        return $this->config['host'] . ':' . $this->config['port'];
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
