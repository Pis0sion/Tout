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

namespace App\Validate;

use App\Exception\ParametersException;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Utils\Arr;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;

/**
 * \App\Validate\BaseValidate.
 */
class BaseValidate
{
    /**
     * @var \Hyperf\HttpServer\Contract\RequestInterface
     */
    #[Inject]
    protected RequestInterface $request;

    /**
     * @var \Hyperf\Validation\Contract\ValidatorFactoryInterface
     */
    #[Inject]
    protected ValidatorFactoryInterface $validatorFactory;

    /**
     * @var array
     */
    protected array $rules = [];

    /**
     * @var array
     */
    protected array $messages = [];

    /**
     * @var array
     */
    protected array $scene = [];

    /**
     * check rules whether though.
     */
    public function checkOrFails(?string $scene): bool
    {
        $_rules = $this->rules;
        if ($scene && Arr::exists($this->scene, $scene) && Arr::accessible($this->scene[$scene])) {
            $_sceneRule = [];
            foreach ($this->scene[$scene] as $item) {
                ($this->rules[$item] ?? '') && $_sceneRule[$item] = $this->rules[$item];
            }
            $_rules = $_sceneRule;
        }

        $_validator = $this->validatorFactory->make($this->request->all(), $_rules, $this->messages);
        if ($_validator->fails()) {
            throw new ParametersException(errMessage: $_validator->errors()->first());
        }

        return true;
    }
}
