<?php

namespace Bilalbaraz\LaravelKibana\Tests\Client;

use Bilalbaraz\LaravelKibana\Client\KibanaFeature;
use Bilalbaraz\LaravelKibana\Tests\KibanaTestCase;
use GuzzleHttp\Client;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class KibanaFeatureTest
 * @package Bilalbaraz\LaravelKibana\Tests\Client
 * @coversDefaultClass \Bilalbaraz\LaravelKibana\Client\KibanaFeature
 */
class KibanaFeatureTest extends KibanaTestCase
{
    const CONFIG = ['host' => '127.0.0.1', 'port' => '5601', 'api' => 'api', 'get_features' => 'get_features'];
    const JSON = '[{"id": "name"}]';
    /** @var Client|MockObject $client */
    private $client;
    /** @var KibanaFeature|MockObject $kibana */
    private $kibana;

    /**
     * @param array $ignoreMethods
     */
    public function getClassMock($ignoreMethods = [])
    {
        $this->client = $this->getMockBuilder(Client::class)->setMethods(['request', 'getBody'])->getMock();
        $this->kibana = $this->getMockBuilder(KibanaFeature::class)
            ->setConstructorArgs([$this->client, self::CONFIG])
            ->setMethodsExcept($ignoreMethods)
            ->getMock();
    }

    /**
     * @test
     * @covers ::getFeatures
     */
    function it_should_get_features()
    {
        $this->getClassMock(['getFeatures']);
        $fullUrl = self::CONFIG['host'] . ':' . self::CONFIG['port'] . '/api/';
        $array = json_decode(self::JSON, true);

        $this->kibana
            ->expects($this->once())
            ->method('getKibanaBaseUrl')
            ->willReturn($fullUrl);
        $this->kibana
            ->expects($this->once())
            ->method('makeRequest')
            ->with($fullUrl . 'features')
            ->willReturn(self::JSON);
        $this->kibana
            ->expects($this->once())
            ->method('toArray')
            ->with(self::JSON)
            ->willReturn($array);

        $this->assertEquals($array, $this->kibana->getFeatures());
    }
}
