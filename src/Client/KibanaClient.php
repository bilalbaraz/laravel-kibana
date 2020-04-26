<?php

namespace Bilalbaraz\LaravelKibana\Client;

use Bilalbaraz\LaravelKibana\Enums\EndpointEnums;
use GuzzleHttp\Client;

/**
 * Class KibanaClient
 * @package Bilalbaraz\LaravelKibana\Client
 */
abstract class KibanaClient
{
    protected $client;
    protected $config;

    /**
     * KibanaClient constructor.
     * @param Client $client
     * @param array $config
     */
    public function __construct(Client $client, array $config = [])
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @param string $endpoint
     * @param string $method
     * @param array $body
     * @param bool $sendAsJson
     * @return string
     */
    public function makeRequest($endpoint, $method = 'GET', $body = [], $sendAsJson = false): string
    {
        $type = $sendAsJson ? 'body' : 'form_params';
        $data = $sendAsJson ? json_encode($body) : $body;
        $structure = ['headers' => ['kbn-xsrf' => true], $type => $data];
        $auth = [$this->config['security']['username'], $this->config['security']['password']];

        if ($this->config['security']['enabled'] === true) {
            $structure['auth'] = $auth;
        }

        return $this->client->request($method, $endpoint, $structure)->getBody()->getContents();
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
    public function toArray($json): array
    {
        return json_decode($json, true);
    }
}
