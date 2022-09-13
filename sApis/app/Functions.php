<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use App\Kernel\Enum\ResponseCodeEnum;
use Hyperf\Contract\LengthAwarePaginatorInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Snowflake\IdGeneratorInterface;
use Hyperf\Utils\ApplicationContext;
use HyperfExt\Auth\Contracts\AuthManagerInterface;
use HyperfExt\Auth\Contracts\GuardInterface;
use HyperfExt\Auth\Contracts\StatefulGuardInterface;
use HyperfExt\Auth\Contracts\StatelessGuardInterface;
use HyperfExt\Auth\Guards\JwtGuard;

if (!function_exists('response')) {
    function response()
    {
        return make(ResponseInterface::class);
    }
}

if (!function_exists('renderResponse')) {
    function renderResponse(mixed $responseData = null)
    {
        $applyResponse = [
            'errCode' => (ResponseCodeEnum::SUCCESS_CODE)->value,
            'errMessage' => 'success',
            'responseData' => $responseData,
        ];

        return response()->json(array_filter($applyResponse));
    }
}

if (!function_exists('auth')) {
    function auth($guard = 'api'): StatefulGuardInterface|GuardInterface|StatelessGuardInterface|JwtGuard
    {
        return make(AuthManagerInterface::class)->guard($guard);
    }
}

if (!function_exists('paginate')) {
    function paginate(LengthAwarePaginatorInterface $PaginateList): array
    {
        return ['listItem' => $PaginateList->items(), 'pageItem' => [
            'totalCount' => $PaginateList->total(),
            'currentPage' => $PaginateList->currentPage(),
            'perPage' => $PaginateList->perPage(),],
        ];
    }
}

if (!function_exists('di')) {
    function di()
    {
        return ApplicationContext::getContainer();
    }
}

if (!function_exists('real2Ip')) {
    function real2Ip()
    {
        $request = ApplicationContext::getContainer()->get(RequestInterface::class);
        $headers = $request->getHeaders();

        if (isset($headers['x-forwarded-for'][0]) && !empty($headers['x-forwarded-for'][0])) {
            return $headers['x-forwarded-for'][0];
        }
        if (isset($headers['x-real-ip'][0]) && !empty($headers['x-real-ip'][0])) {
            return $headers['x-real-ip'][0];
        }

        $serverParams = $request->getServerParams();
        return $serverParams['remote_addr'] ?? '';
    }
}

if (!function_exists('makeSubOrderNo')) {
    function makeSubOrderNo(): string
    {
        $snowFlake = ApplicationContext::getContainer()->get(IdGeneratorInterface::class)->generate();
        return \Carbon\Carbon::now()->rawFormat('Ymd') . $snowFlake;
    }
}

