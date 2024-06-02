<?php

declare(strict_types=1);

namespace Api\Middleware;

use App\System\Service\SystemApiService;
use Mine\Annotation\Api\MApi;
use PhpOffice\PhpSpreadsheet\Writer\Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class VerifyParamsMiddleware implements MiddlewareInterface
{
    /**
     * 验证接口参数.
     * @throws Exception
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $apiData = $request->getParsedBody()['apiData'];
        $requestData = $this->getRequestData($request, $apiData);

        $columns = container()->get(SystemApiService::class)
            ->getColumnListByApiId((string) $apiData['id'])['api_column'];

        // todo...

        return $handler->handle($request);
    }

    protected function getRequestData(ServerRequestInterface $request, &$apiData): array
    {
        $bodyData = $request->getParsedBody();
        unset($bodyData['apiData']);

        if ($apiData['request_mode'] === MApi::METHOD_GET) {
            $params = $request->getQueryParams();
        } elseif ($apiData['request_mode'] === MApi::METHOD_ALL) {
            $params = array_merge($request->getQueryParams(), $bodyData);
        } else {
            $params = &$bodyData;
        }

        return $params;
    }
}
