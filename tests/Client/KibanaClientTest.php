<?php

namespace Bilalbaraz\LaravelKibana\Tests\Client;

use Bilalbaraz\LaravelKibana\Client\KibanaClient;
use Bilalbaraz\LaravelKibana\Tests\KibanaTestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class KibanaClientTest
 * @package Bilalbaraz\LaravelKibana\Tests\Client
 * @coversDefaultClass \Bilalbaraz\LaravelKibana\Client\KibanaClient
 */
class KibanaClientTest extends KibanaTestCase
{
    const CONFIG = [
        'host' => '127.0.0.1',
        'port' => '5601',
        'security' => ['enabled' => false, 'username' => 'admin', 'password' => 'admin'],
        'api' => 'api',
        'get_features' => 'get_features',
    ];
    const JSON = '[{"id": "name"}]';
    /** @var Client|MockObject $client */
    private $client;
    /** @var KibanaClient|MockObject $kibana */
    private $kibana;

    protected function setUp(): void
    {
        parent::setUp();
        $this->getClassMock();
    }

    public function getClassMock()
    {
        $this->client = $this->getMockBuilder(Client::class)->setMethods(['request', 'getBody'])->getMock();
        $this->kibana = $this->getMockForAbstractClass(KibanaClient::class, [$this->client, self::CONFIG]);
    }

    /**
     * @test
     * @covers ::getKibanaBaseUrl
     * @covers ::__construct
     */
    function it_should_return_kibana_base_url()
    {
        $this->assertEquals(
            self::CONFIG['host'] . ':' . self::CONFIG['port'] . '/api/',
            $this->kibana->getKibanaBaseUrl()
        );
    }

    /**
     * @test
     * @covers ::makeRequest
     */
    function it_should_make_request()
    {
        $response = $this->createMock(Response::class);
        $stream = $this->createMock(Stream::class);
        $url = 'http://127.0.0.1:5601/api/features';
        $structure = ['headers' => ['kbn-xsrf' => true], 'form_params' => []];

        $this->client->expects($this->once())->method('request')->with('GET', $url, $structure)->willReturn($response);
        $response->expects($this->once())->method('getBody')->willReturn($stream);
        $stream->expects($this->once())->method('getContents')->willReturn(self::JSON);

        $this->assertEquals(self::JSON, $this->kibana->makeRequest($url));
    }

    /**
     * @test
     * @covers ::toArray
     */
    function it_should_convert_json_string_to_array()
    {
        $this->assertEquals(json_decode(self::JSON, true), $this->kibana->toArray(self::JSON));
    }
}
