<?php

namespace Bilalbaraz\LaravelKibana\Tests\Client;

use Bilalbaraz\LaravelKibana\Client\KibanaSpace;
use Bilalbaraz\LaravelKibana\Tests\KibanaTestCase;
use GuzzleHttp\Client;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class KibanaSpaceTest
 * @package Bilalbaraz\LaravelKibana\Tests\Client
 * @coversDefaultClass \Bilalbaraz\LaravelKibana\Client\KibanaSpace
 */
class KibanaSpaceTest extends KibanaTestCase
{
    const CONFIG = ['host' => '127.0.0.1', 'port' => '5601', 'api' => 'api', 'get_features' => 'get_features'];
    const JSON = '[{"id": "name"}]';
    /** @var Client|MockObject $client */
    private $client;
    /** @var KibanaSpace|MockObject $kibana */
    private $kibana;

    /**
     * @param array $ignoreMethods
     */
    public function getClassMock($ignoreMethods = [])
    {
        $this->client = $this->getMockBuilder(Client::class)->setMethods(['request', 'getBody'])->getMock();
        $this->kibana = $this->getMockBuilder(KibanaSpace::class)
            ->setConstructorArgs([$this->client, self::CONFIG])
            ->setMethodsExcept($ignoreMethods)
            ->getMock();
    }

    /**
     * @test
     * @covers ::getSpaces
     */
    function it_should_get_spaces()
    {
        $this->getClassMock(['getSpaces']);
        $fullUrl = self::CONFIG['host'] . ':' . self::CONFIG['port'] . '/api/';
        $array = json_decode(self::JSON, true);

        $this->kibana
            ->expects($this->once())
            ->method('getKibanaBaseUrl')
            ->willReturn($fullUrl);
        $this->kibana
            ->expects($this->once())
            ->method('makeRequest')
            ->with($fullUrl . 'spaces/space')
            ->willReturn(self::JSON);
        $this->kibana
            ->expects($this->once())
            ->method('toArray')
            ->with(self::JSON)
            ->willReturn($array);

        $this->assertEquals($array, $this->kibana->getSpaces());
    }

    /**
     * @test
     * @covers ::getSpace
     */
    function it_should_get_space_by_space_id()
    {
        $this->getClassMock(['getSpace']);
        $fullUrl = self::CONFIG['host'] . ':' . self::CONFIG['port'] . '/api/';
        $array = json_decode(self::JSON, true);
        $spaceId = 'default';

        $this->kibana
            ->expects($this->once())
            ->method('getKibanaBaseUrl')
            ->willReturn($fullUrl);
        $this->kibana
            ->expects($this->once())
            ->method('makeRequest')
            ->with($fullUrl . 'spaces/space/' . $spaceId)
            ->willReturn(self::JSON);
        $this->kibana
            ->expects($this->once())
            ->method('toArray')
            ->with(self::JSON)
            ->willReturn($array);

        $this->assertEquals($array, $this->kibana->getSpace($spaceId));
    }

    /**
     * @test
     * @covers ::createSpace
     */
    function it_should_create_space()
    {
        $this->getClassMock(['createSpace']);
        $fullUrl = self::CONFIG['host'] . ':' . self::CONFIG['port'] . '/api/';
        $array = json_decode(self::JSON, true);
        $space = ['id' => 'space-id', 'name' => 'space name'];

        $this->kibana
            ->expects($this->once())
            ->method('getKibanaBaseUrl')
            ->willReturn($fullUrl);
        $this->kibana
            ->expects($this->once())
            ->method('makeRequest')
            ->with($fullUrl . 'spaces/space', 'POST', $space)
            ->willReturn(self::JSON);
        $this->kibana
            ->expects($this->once())
            ->method('toArray')
            ->with(self::JSON)
            ->willReturn($array);

        $this->assertEquals($array, $this->kibana->createSpace($space));
    }

    /**
     * @test
     * @covers ::updateSpace
     */
    function it_should_update_space()
    {
        $this->getClassMock(['updateSpace']);
        $fullUrl = self::CONFIG['host'] . ':' . self::CONFIG['port'] . '/api/';
        $array = json_decode(self::JSON, true);
        $space = ['id' => 'space-id', 'name' => 'space name'];

        $this->kibana
            ->expects($this->once())
            ->method('getKibanaBaseUrl')
            ->willReturn($fullUrl);
        $this->kibana
            ->expects($this->once())
            ->method('makeRequest')
            ->with($fullUrl . 'spaces/space/space-id', 'PUT', $space)
            ->willReturn(self::JSON);
        $this->kibana
            ->expects($this->once())
            ->method('toArray')
            ->with(self::JSON)
            ->willReturn($array);

        $this->assertEquals($array, $this->kibana->updateSpace('space-id', $space));
    }

    /**
     * @test
     * @covers ::deleteSpace
     */
    function it_should_delete_space()
    {
        $this->getClassMock(['deleteSpace']);
        $fullUrl = self::CONFIG['host'] . ':' . self::CONFIG['port'] . '/api/';

        $this->kibana
            ->expects($this->once())
            ->method('getKibanaBaseUrl')
            ->willReturn($fullUrl);
        $this->kibana
            ->expects($this->once())
            ->method('makeRequest')
            ->with($fullUrl . 'spaces/space/space-id', 'DELETE')
            ->willReturn(self::JSON);

        $this->assertTrue($this->kibana->deleteSpace('space-id'));
    }
}
