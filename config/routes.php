<?php

declare(strict_types=1);

use App\System\Middleware\WsAuthMiddleware;
use Hyperf\HttpServer\Router\Router;

Router::get('/', static function () {
    return 'welcome use mineAdmin';
});

Router::get('/favicon.ico', static function () {
    return '';
});

// 消息ws服务器
Router::addServer('message', static function () {
    Router::get('/message.io', 'App\System\Controller\ServerController', [
        'middleware' => [WsAuthMiddleware::class],
    ]);
});
