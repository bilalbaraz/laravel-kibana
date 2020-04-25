<?php

namespace Bilalbaraz\LaravelKibana\Tests\Client;

use Bilalbaraz\LaravelKibana\Client\KibanaObject;
use Bilalbaraz\LaravelKibana\Tests\KibanaTestCase;
use GuzzleHttp\Client;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class KibanaObjectTest
 * @package Bilalbaraz\LaravelKibana\Tests\Client
 * @coversDefaultClass \Bilalbaraz\LaravelKibana\Client\KibanaObject
 */
class KibanaObjectTest extends KibanaTestCase
{
    const CONFIG = ['host' => '127.0.0.1', 'port' => '5601', 'api' => 'api', 'get_features' => 'get_features'];
    const JSON = '[{"id": "name"}]';
    const FULL_URL = '127.0.0.1:5601/api/';
    const OBJECT_TYPE = 'dashboard';
    const OBJECT_ID = 'object-id';
    /** @var Client|MockObject $client */
    private $client;
    /** @var KibanaObject|MockObject $kibana */
    private $kibana;

    /**
     * @param array $ignoreMethods
     */
    public function getClassMock($ignoreMethods = [])
    {
        $this->client = $this->getMockBuilder(Client::class)->setMethods(['request', 'getBody'])->getMock();
        $this->kibana = $this->getMockBuilder(KibanaObject::class)
            ->setConstructorArgs([$this->client, self::CONFIG])
            ->setMethodsExcept($ignoreMethods)
            ->getMock();
    }

    /**
     * @test
     * @covers ::getSavedObject
     */
    function it_should_get_saved_object()
    {
        $this->getClassMock(['getSavedObject']);
        $array = json_decode(self::JSON, true);

        $this->kibana
            ->expects($this->once())
            ->method('getKibanaBaseUrl')
            ->willReturn(self::FULL_URL);
        $this->kibana
            ->expects($this->once())
            ->method('makeRequest')
            ->with(self::FULL_URL . 'saved_objects/' . self::OBJECT_TYPE . '/' . self::OBJECT_ID)
            ->willReturn(self::JSON);
        $this->kibana
            ->expects($this->once())
            ->method('toArray')
            ->with(self::JSON)
            ->willReturn($array);

        $this->assertEquals($array, $this->kibana->getSavedObject(self::OBJECT_TYPE, self::OBJECT_ID));
    }

    /**
     * @test
     * @covers ::findObjects
     */
    function it_should_find_objects()
    {
        $this->getClassMock(['findObjects']);
        $array = json_decode(self::JSON, true);

        $this->kibana
            ->expects($this->once())
            ->method('getKibanaBaseUrl')
            ->willReturn(self::FULL_URL);
        $this->kibana
            ->expects($this->once())
            ->method('makeRequest')
            ->with(self::FULL_URL . 'saved_objects/_find?type=' . self::OBJECT_TYPE)
            ->willReturn(self::JSON);
        $this->kibana
            ->expects($this->once())
            ->method('toArray')
            ->with(self::JSON)
            ->willReturn($array);

        $this->assertEquals($array, $this->kibana->findObjects(self::OBJECT_TYPE));
    }

    /**
     * @test
     * @covers ::exportObjects
     */
    function it_should_export_object()
    {
        $this->getClassMock(['exportObjects']);
        $array = json_decode(self::JSON, true);
        $objects = ['type' => 'dashboard'];

        $this->kibana
            ->expects($this->once())
            ->method('getKibanaBaseUrl')
            ->willReturn(self::FULL_URL);
        $this->kibana
            ->expects($this->once())
            ->method('makeRequest')
            ->with(self::FULL_URL . 'saved_objects/_export', 'POST', $objects, true)
            ->willReturn(self::JSON);
        $this->kibana
            ->expects($this->once())
            ->method('toArray')
            ->with(self::JSON)
            ->willReturn($array);

        $this->assertEquals([$array], $this->kibana->exportObjects(["type" => self::OBJECT_TYPE]));
    }

    /**
     * @test
     * @covers ::getBulkObjects
     */
    function it_should_get_bulk_objects()
    {
        $this->getClassMock(['getBulkObjects']);
        $array = json_decode(self::JSON, true);
        $objects = [['type' => 'dashboard', 'id' => 'dashboard-1234']];

        $this->kibana
            ->expects($this->once())
            ->method('getKibanaBaseUrl')
            ->willReturn(self::FULL_URL);
        $this->kibana
            ->expects($this->once())
            ->method('makeRequest')
            ->with(self::FULL_URL . 'saved_objects/_bulk_get', 'POST', $objects, true)
            ->willReturn(self::JSON);
        $this->kibana
            ->expects($this->once())
            ->method('toArray')
            ->with(self::JSON)
            ->willReturn($array);

        $this->assertEquals($array, $this->kibana->getBulkObjects($objects));
    }
}
