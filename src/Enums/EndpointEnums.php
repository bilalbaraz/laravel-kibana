<?php

namespace Bilalbaraz\LaravelKibana\Enums;

/**
 * Class EndpointEnums
 * @package Bilalbaraz\LaravelKibana\Enums
 */
final class EndpointEnums
{
    const API = 'api';
    const GET_FEATURES = 'features';
    const GET_SPACES = 'spaces/space';
    const GET_SAVED_OBJECTS = 'saved_objects';
    const GET_BULK_OBJECTS = self::GET_SAVED_OBJECTS . '/_bulk_get';
    const FIND_OBJECTS = self::GET_SAVED_OBJECTS . '/_find';
    const EXPORT_OBJECTS = self::GET_SAVED_OBJECTS . '/_export';
}
