<?php

declare(strict_types=1);

namespace App\Setting\Controller;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\Middleware;
use Mine\Annotation\Auth;
use Mine\Middlewares\CheckModuleMiddleware;
use Mine\MineController;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * setting 公共方法控制器
 * Class CommonController.
 */
#[Controller(prefix: 'setting/common'), Auth]
#[Middleware(middleware: CheckModuleMiddleware::class)]
class CommonController extends MineController
{
    /**
     * 返回模块信息及表前缀
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    #[GetMapping('getModuleList')]
    public function getModuleList(): ResponseInterface
    {
        $this->mine->scanModule();

        return $this->success($this->mine->getModuleInfo());
    }
}
