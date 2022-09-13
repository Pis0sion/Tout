<?php

namespace App\Exception\Handler;

use App\Exception\BaseException;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * \App\Exception\Handler\ToutApiExceptionHandler
 */
class ToutApiExceptionHandler extends ExceptionHandler
{

    /**
     * handle
     * @param \Throwable $throwable
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        /*
         * @var BaseException $throwable
         */
        return $response->withHeader('content-type', 'application/json')
            ->withHeader("Server", "Tengine")
            ->withStatus($throwable->httpCode)
            ->withBody(new SwooleStream(json_encode([
                'errCode' => $throwable->errCode,
                'errMessage' => $throwable->errMessage,
            ])));
    }

    /**
     * isValid
     * @param \Throwable $throwable
     * @return bool
     */
    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof BaseException;
    }
}