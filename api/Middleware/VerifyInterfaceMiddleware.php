<?php

declare(strict_types=1);
/**
 * This file is part of MineAdmin.
 *
 * @link     https://www.mineadmin.com
 * @document https://doc.mineadmin.com
 * @contact  root@imoi.cn
 * @license  https://github.com/mineadmin/MineAdmin/blob/master/LICENSE
 */

namespace Api\Middleware;

use App\System\Model\SystemApi;
use App\System\Service\SystemApiService;
use App\System\Service\SystemAppService;
use Hyperf\Context\Context;
use Hyperf\Di\Annotation\Inject;
use Mine\Annotation\Api\MApi;
use Mine\Annotation\Api\MApiCollector;
use Mine\Event\ApiAfter;
use Mine\Event\ApiBefore;
use Mine\Exception\NormalStatusException;
use Mine\Helper\MineCode;
use Mine\MineRequest;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\SimpleCache\InvalidArgumentException;

class VerifyInterfaceMiddleware implements MiddlewareInterface
{
    /**
     * 事件调度器.
     */
    #[Inject]
    protected EventDispatcherInterface $evDispatcher;

    /**
     * 验证检查接口.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->run($request, $handler);
    }

    /**
     * 访问接口鉴权处理.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    protected function auth(ServerRequestInterface $request): int
    {
        try {
            /* @var $service SystemAppService */
            $service = container()->get(SystemAppService::class);
            $queryParams = $request->getQueryParams();
            $apiData = $this->_getApiData();
            switch ($apiData['auth_mode']) {
                case MApi::AUTH_MODE_EASY:
                    if (empty($queryParams['app_id'])) {
                        return MineCode::API_APP_ID_MISSING;
                    }
                    if (empty($queryParams['identity'])) {
                        return MineCode::API_IDENTITY_MISSING;
                    }
                    return $service->verifyEasyMode($queryParams['app_id'], $queryParams['identity'], $apiData);
                case MApi::AUTH_MODE_NORMAL:
                    if (empty($queryParams['access_token'])) {
                        return MineCode::API_ACCESS_TOKEN_MISSING;
                    }
                    return $service->verifyNormalMode($queryParams['access_token'], $apiData);
                default:
                    throw new \RuntimeException();
            }
        } catch (\Throwable $e) {
            throw new NormalStatusException(t('mineadmin.api_auth_exception'), MineCode::API_AUTH_EXCEPTION);
        }
    }

    /**
     * API常规检查.
     * @param mixed $request
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    protected function apiModelCheck($request): ServerRequestInterface
    {
        // 先对注解检测，有直接放行
        $apiData = MApiCollector::getApiInfos();
        $mineRequest = container()->get(MineRequest::class);

        if (isset($apiData[$mineRequest->route('method')])) {
            $apiModel = $apiData[$mineRequest->route('method')];

            // 检查接口是否停用
            if ($apiModel['status'] == SystemApi::DISABLE) {
                throw new NormalStatusException(t('mineadmin.api_stop'), MineCode::RESOURCE_STOP);
            }

            // 检查接口请求方法
            if ($apiModel['request_mode'] !== MApi::METHOD_ALL && $request->getMethod()[0] !== $apiModel['request_mode']) {
                throw new NormalStatusException(
                    t('mineadmin.not_allow_method', ['method' => $request->getMethod()]),
                    MineCode::METHOD_NOT_ALLOW
                );
            }

            $this->_setApiData($apiModel);

            // 合并入参
            return $request->withParsedBody(array_merge(
                $request->getParsedBody(),
                ['apiData' => $apiModel]
            ));
        }

        $service = container()->get(SystemApiService::class);
        $apiModel = $service->mapper->one(function ($query) {
            $request = container()->get(MineRequest::class);
            $query->where('access_name', $request->route('method'));
        });

        // 检查接口是否存在
        if (! $apiModel) {
            throw new NormalStatusException(t('mineadmin.not_found'), MineCode::NOT_FOUND);
        }

        // 检查接口是否停用
        if ($apiModel['status'] == SystemApi::DISABLE) {
            throw new NormalStatusException(t('mineadmin.api_stop'), MineCode::RESOURCE_STOP);
        }

        // 检查接口请求方法
        if ($apiModel['request_mode'] !== MApi::METHOD_ALL && $request->getMethod()[0] !== $apiModel['request_mode']) {
            throw new NormalStatusException(
                t('mineadmin.not_allow_method', ['method' => $request->getMethod()]),
                MineCode::METHOD_NOT_ALLOW
            );
        }

        $this->_setApiData($apiModel->toArray());

        // 合并入参
        return $request->withParsedBody(array_merge(
            $request->getParsedBody(),
            ['apiData' => $apiModel->toArray()]
        ));
    }

    /**
     * 运行.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     * @throws InvalidArgumentException
     */
    protected function run(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->evDispatcher->dispatch(new ApiBefore());

        $request = $this->apiModelCheck($request);

        if (($code = $this->auth($request)) !== MineCode::API_VERIFY_PASS) {
            throw new NormalStatusException(t('mineadmin.api_auth_fail'), $code);
        }

        $result = $handler->handle($request);

        $event = new ApiAfter($this->_getApiData(), $result);
        $this->evDispatcher->dispatch($event);

        return $event->getResult();
    }

    /**
     * 设置协程上下文.
     */
    private function _setApiData(array $data)
    {
        Context::set('apiData', $data);
    }

    /**
     * 获取协程上下文.
     */
    private function _getApiData(): array
    {
        return Context::get('apiData', []);
    }
}
