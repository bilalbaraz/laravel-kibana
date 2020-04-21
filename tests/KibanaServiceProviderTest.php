<?php

namespace Bilalbaraz\LaravelKibana\Tests;

use Bilalbaraz\LaravelKibana\KibanaServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class KibanaServiceProviderTest
 * @package Bilalbaraz\LaravelKibana\Tests
 * @coversDefaultClass \Bilalbaraz\LaravelKibana\KibanaServiceProvider
 */
class KibanaServiceProviderTest extends TestCase
{
    /** @var MockObject|Application $application */
    private $application;
    private $serviceProvider;

    protected function setUp(): void
    {
        $this->application = \Mockery::mock(Application::class);
        $this->serviceProvider = new KibanaServiceProvider($this->application);
        parent::setUp();
    }

    /**
     * @test
     */
    function it_can_be_constructed()
    {
        $this->assertInstanceOf(ServiceProvider::class, $this->serviceProvider);
    }
}
