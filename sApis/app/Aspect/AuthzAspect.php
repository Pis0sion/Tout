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

use App\Annotation\Authz;
use App\Exception\InvalidTokenException;
use Hyperf\Context\Context;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use HyperfExt\Auth\Contracts\AuthenticatableInterface;
use HyperfExt\Jwt\Exceptions\TokenExpiredException;
use Psr\Http\Message\ResponseInterface;

/**
 * \App\Aspect\AuthzAspect.
 */
#[Aspect]
class AuthzAspect extends AbstractAspect
{
    /**
     * @var string[]
     */
    public $annotations =
        [
            Authz::class,
        ];

    /**
     * process
     * @param \Hyperf\Di\Aop\ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $annotation = $proceedingJoinPoint->getAnnotationMetadata();
        $authAnnotation = $annotation->class[Authz::class] ?? $annotation->method[Authz::class];
        $guards = empty($authAnnotation->guards) ? [null] : $authAnnotation->guards;
        $passable = $authAnnotation->passable;

        foreach ($guards as $name) {
            $this->authentication($name, $passable);
        }
        return $proceedingJoinPoint->process();
    }

    /**
     * @throws InvalidTokenException
     */
    protected function authentication(string $name, bool $passable)
    {
        try {
            auth($name)->checkOrFail();
        } catch (\Throwable $throwable) {
            if ($throwable instanceof TokenExpiredException) {
                $refreshToken = auth($name)->refresh();
                Context::override(
                    ResponseInterface::class,
                    fn(ResponseInterface $response) => $response->withAddedHeader('refresh-token', $refreshToken)
                );
            }
        } finally {
            if (!$passable and !auth($name)->user() instanceof AuthenticatableInterface) {
                throw new InvalidTokenException();
            }
        }
    }
}
