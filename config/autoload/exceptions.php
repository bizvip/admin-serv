<?php

declare(strict_types=1);

use Hyperf\HttpServer\Exception\Handler\HttpExceptionHandler;
use Mine\Exception\Handler\AppExceptionHandler;
use Mine\Exception\Handler\NoPermissionExceptionHandler;
use Mine\Exception\Handler\NormalStatusExceptionHandler;
use Mine\Exception\Handler\TokenExceptionHandler;
use Mine\Exception\Handler\ValidationExceptionHandler;

return [
    'handler' => [
        'http' => [
            HttpExceptionHandler::class,
            ValidationExceptionHandler::class,
            TokenExceptionHandler::class,
            NoPermissionExceptionHandler::class,
            NormalStatusExceptionHandler::class,
            AppExceptionHandler::class,
        ],
    ],
];
