<?php

declare(strict_types=1);

use Hyperf\Amqp\IO\IOFactory;

use function Hyperf\Support\env;

return [
    'enable'  => env('AMQP_ENABLE'),
    'default' => [
        'host'       => env('AMQP_HOST', 'localhost'),
        'port'       => (int)env('AMQP_PORT', 5672),
        'user'       => env('AMQP_USER', 'guest'),
        'password'   => env('AMQP_PASSWORD', 'guest'),
        'vhost'      => env('AMQP_VHOST', '/'),
        'open_ssl'   => false,
        'concurrent' => [
            'limit' => 2,
        ],
        'pool'       => [
            'connections' => 2,
        ],
        'io'         => IOFactory::class,
        'params'     => [
            'insist'              => false,
            'login_method'        => 'AMQPLAIN',
            'login_response'      => null,
            'locale'              => 'en_US',
            'connection_timeout'  => 3,
            'read_write_timeout'  => 6,
            'context'             => null,
            'keepalive'           => true,
            'heartbeat'           => 3,
            'channel_rpc_timeout' => 0.0,
            'close_on_destruct'   => false,
            'max_idle_channels'   => 10,
        ],
    ],
];
