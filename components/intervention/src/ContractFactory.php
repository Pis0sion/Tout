<?php

namespace Pis0sion\Intervention;

use Hyperf\Utils\Collection;
use Pis0sion\Intervention\Contract\ContractGeneratorFactoryInterface;

/**
 * \Pis0sion\Intervention\ContractFactory
 */
class ContractFactory
{
    /**
     * __invoke
     */
    public function __invoke()
    {
        return make(ContractGenerator::class);
    }
}