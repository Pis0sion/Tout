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
namespace App\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\HttpServer\Contract\RequestInterface;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * \App\Aspect\ProxyRequestAspect.
 */
#[Aspect]
class ProxyRequestAspect extends AbstractAspect
{
    /**
     * @var array
     */
    public $classes = [
        'App\\Servlet\\WechatServlet::customer2RelationshipByCallback',
        'App\\Repositories\\GoodsOrderRepositories::notify',
    ];

    #[Inject]
    protected RequestInterface $originRequest;

    /**
     * @throws \Hyperf\Di\Exception\Exception
     * @return mixed
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        di()->set('symfonyRequest', $this->buildSymfonyRequest());
        return $proceedingJoinPoint->process();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function buildSymfonyRequest()
    {
        $symfonyRequest = new Request(
            query: $this->originRequest->getQueryParams(),
            request: $this->originRequest->getParsedBody(),
            cookies: $this->originRequest->getCookieParams(),
            server: $this->originRequest->getServerParams(),
            content: $this->originRequest->getBody()->getContents()
        );

        $symfonyRequest->headers = new HeaderBag($this->originRequest->getHeaders());
        return $symfonyRequest;
    }
}
