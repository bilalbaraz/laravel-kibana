<?php

namespace Bilalbaraz\LaravelKibana\Tests\Client;

use Bilalbaraz\LaravelKibana\Client\Kibana;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

/**
 * Class KibanaTest
 * @package Bilalbaraz\LaravelKibana\Tests\Client
 * @coversDefaultClass \Bilalbaraz\LaravelKibana\Client\Kibana
 */
class KibanaTest extends TestCase
{
    const CONFIG = ['host' => '127.0.0.1', 'port' => '5601', 'api' => 'api', 'get_features' => 'get_features'];
    const JSON = '[{"id": "name"}]';
    /** @var Client|MockObject $client */
    private $client;
    /** @var Kibana|MockObject $kibana */
    private $kibana;

    /**
     * @param array $ignoreMethods
     */
    public function getClassMock($ignoreMethods = [])
    {
        $this->client = $this->getMockBuilder(Client::class)->setMethods(['request', 'getBody'])->getMock();
        $this->kibana = $this->getMockBuilder(Kibana::class)
            ->setConstructorArgs([$this->client, self::CONFIG])
            ->setMethodsExcept($ignoreMethods)
            ->getMock();
    }

    /**
     * @test
     * @covers ::getKibanaBaseUrl
     * @covers ::__construct
     */
    function it_should_return_kibana_base_url()
    {
        $this->getClassMock(['getKibanaBaseUrl']);

        $this->assertEquals(
            self::CONFIG['host'] . ':' . self::CONFIG['port'] . '/api/',
            $this->kibana->getKibanaBaseUrl()
        );
    }

    /**
     * @test
     * @covers ::toArray
     */
    function it_should_convert_json_string_to_array()
    {
        $class = new Kibana(new Client(), self::CONFIG);

        $result = $this->invokeMethod($class, 'toArray', [self::JSON]);

        $this->assertEquals(json_decode(self::JSON, true), $result);
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
     * @covers ::makeRequest
     */
    function it_should_make_request()
    {
        $this->getClassMock(['makeRequest']);
        $response = $this->createMock(Response::class);
        $stream = $this->createMock(Stream::class);
        $url = 'http://127.0.0.1:5601/api/features';

        $this->client->expects($this->once())->method('request')->with('GET', $url)->willReturn($response);
        $response->expects($this->once())->method('getBody')->willReturn($stream);
        $stream->expects($this->once())->method('getContents')->willReturn(self::JSON);

        $this->assertEquals(self::JSON, $this->kibana->makeRequest($url));
    }

    /**
     * @param $object
     * @param $methodName
     * @param array $parameters
     * @return mixed
     * @throws ReflectionException
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
}
