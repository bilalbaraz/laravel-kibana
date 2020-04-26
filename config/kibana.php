<?php

return [
    'version' => env('KIBANA_VERSION', '7.6.2'),
    'host' => env('KIBANA_HOST', '127.0.0.1'),
    'port' => env('KIBANA_PORT', '5601'),
    'security' => [
        'enabled' => env('KIBANA_SECURITY_ENABLED', false),
        'username' => env('KIBANA_USERNAME', null),
        'password' => env('KIBANA_PASSWORD', null),
    ],
];
