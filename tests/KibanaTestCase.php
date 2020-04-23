<?php

namespace Bilalbaraz\LaravelKibana\Tests;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

/**
 * Class KibanaTestCase
 * @package Bilalbaraz\LaravelKibana\Tests
 */
abstract class KibanaTestCase extends TestCase
{
    /**
     * @param $object
     * @param $methodName
     * @param array $parameters
     * @return mixed
     * @throws ReflectionException
     */
    public function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }
}
