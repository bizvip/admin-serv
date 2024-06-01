<?php

declare(strict_types=1);

use Mine\Log\Processor\UuidRequestIdProcessor;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

return [
    'default' => [
        'handler'   => [
            'class'       => RotatingFileHandler::class,
            'constructor' => [
                'filename' => BASE_PATH . '/runtime/logs/debug/mine.log',
                'level'    => Logger::DEBUG,
            ],
        ],
        'formatter' => [
            'class'       => LineFormatter::class,
            'constructor' => [
                'format'                => null,
                'dateFormat'            => 'Y-m-d H:i:s',
                'allowInlineLineBreaks' => true,
            ],
        ],
        'processor' => [
            'class' => UuidRequestIdProcessor::class,
        ],
    ],
    'sql'     => [
        'handler'   => [
            'class'       => RotatingFileHandler::class,
            'constructor' => [
                'filename' => BASE_PATH . '/runtime/logs/sql/sql.log',
                'level'    => Logger::DEBUG,
            ],
        ],
        'formatter' => [
            'class'       => LineFormatter::class,
            'constructor' => [
                'format'                => null,
                'dateFormat'            => 'Y-m-d H:i:s',
                'allowInlineLineBreaks' => true,
            ],
        ],
        'processor' => [
            'class' => UuidRequestIdProcessor::class,
        ],
    ],
];
