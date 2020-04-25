<?php

namespace Bilalbaraz\LaravelKibana\Tests\Client;

use Bilalbaraz\LaravelKibana\Client\KibanaDashboard;
use Bilalbaraz\LaravelKibana\Tests\KibanaTestCase;
use GuzzleHttp\Client;
use PHPUnit\Framework\MockObject\MockObject;

/**
 * Class KibanaDashboardTest
 * @package Bilalbaraz\LaravelKibana\Tests\Client
 * @coversDefaultClass \Bilalbaraz\LaravelKibana\Client\KibanaDashboard
 */
class KibanaDashboardTest extends KibanaTestCase
{
    const CONFIG = ['host' => '127.0.0.1', 'port' => '5601', 'api' => 'api', 'get_features' => 'get_features'];
    const JSON = '[{"id": "name"}]';
    /** @var Client|MockObject $client */
    private $client;
    /** @var KibanaDashboard|MockObject $kibana */
    private $kibana;

    /**
     * @param array $ignoreMethods
     */
    public function getClassMock($ignoreMethods = [])
    {
        $this->client = $this->getMockBuilder(Client::class)->setMethods(['request', 'getBody'])->getMock();
        $this->kibana = $this->getMockBuilder(KibanaDashboard::class)
            ->setConstructorArgs([$this->client, self::CONFIG])
            ->setMethodsExcept($ignoreMethods)
            ->getMock();
    }

    /**
     * @test
     * @covers ::exportDashboard
     */
    function it_should_export_dashboard()
    {
        $this->getClassMock(['exportDashboard']);
        $fullUrl = self::CONFIG['host'] . ':' . self::CONFIG['port'] . '/api/';
        $array = json_decode(self::JSON, true);
        $dashboardId = 'dashboard-id-1234';

        $this->kibana
            ->expects($this->once())
            ->method('getKibanaBaseUrl')
            ->willReturn($fullUrl);
        $this->kibana
            ->expects($this->once())
            ->method('makeRequest')
            ->with($fullUrl . 'kibana/dashboards/export?dashboard=' . $dashboardId)
            ->willReturn(self::JSON);
        $this->kibana
            ->expects($this->once())
            ->method('toArray')
            ->with(self::JSON)
            ->willReturn($array);

        $this->assertEquals($array, $this->kibana->exportDashboard($dashboardId));
    }

    /**
     * @test
     * @covers ::importDashboard
     */
    function it_should_import_dashboard()
    {
        $this->getClassMock(['importDashboard']);
        $fullUrl = self::CONFIG['host'] . ':' . self::CONFIG['port'] . '/api/';
        $array = json_decode(self::JSON, true);
        $body = [
            'objects' => [
                [
                    'id' => 'dashboard-id-1234-5678',
                    'type' => 'dashboard',
                    'version' => 1,
                    'attributes' => [
                        'title' => 'Example Dashboard',
                        'hits' => 0,
                        'description' => 'example dashboard description',
                        'panelsJSON' => '[]',
                        'optionsJSON' => '{}',
                        'version' => 1,
                        'timeRestore' => false,
                        'kibanaSavedObjectMeta' => [
                            'searchSourceJSON' => '{"query":{"query":"","language":"lucene"},"filter":[]}',
                        ],
                    ],
                ],
            ],
        ];

        $this->kibana
            ->expects($this->once())
            ->method('getKibanaBaseUrl')
            ->willReturn($fullUrl);
        $this->kibana
            ->expects($this->once())
            ->method('makeRequest')
            ->with($fullUrl . 'kibana/dashboards/import', 'POST', $body, true)
            ->willReturn(self::JSON);
        $this->kibana
            ->expects($this->once())
            ->method('toArray')
            ->with(self::JSON)
            ->willReturn($array);

        $this->assertEquals($array, $this->kibana->importDashboard($body));
    }
}
