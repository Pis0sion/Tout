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

use App\Annotation\Validation;
use App\Validate\BaseValidate;
use Hyperf\Contract\ContainerInterface;
use Hyperf\Di\Annotation\AnnotationCollector;
use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * \App\Aspect\ValidatorAspect.
 */
#[Aspect]
class ValidatorAspect extends AbstractAspect
{
    /**
     * @var string[]
     */
    public $annotations = [Validation::class];

    /**
     * @var \Hyperf\HttpServer\Contract\RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @var \Hyperf\Contract\ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * @param \Hyperf\HttpServer\Contract\RequestInterface $request
     * @param \Hyperf\Contract\ContainerInterface $container
     */
    public function __construct(RequestInterface $request, ContainerInterface $container)
    {
        $this->request = $request;
        $this->container = $container;
    }

    /**
     * process
     * @param \Hyperf\Di\Aop\ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $_annotationValidateClasses = AnnotationCollector::getClassMethodAnnotation(
            $proceedingJoinPoint->className,
            $proceedingJoinPoint->methodName
        );

        /**
         * @var BaseValidate $_needValidationClass
         */
        if ($_needValidationClass = $this->container->get($_annotationValidateClasses[Validation::class]?->value)) {
            $_validateScene = $_annotationValidateClasses[Validation::class]?->scene;
            $_needValidationClass->checkOrFails($_validateScene);
        }

        return $proceedingJoinPoint->process();
    }
}
