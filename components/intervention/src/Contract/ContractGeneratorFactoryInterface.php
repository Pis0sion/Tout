<?php

namespace Pis0sion\Intervention\Contract;

use Pis0sion\Intervention\ContractGenerator;

/**
 * \Pis0sion\Intervention\ContractGeneratorFactoryInterface
 * @method
 */
interface ContractGeneratorFactoryInterface
{
    /**
     * generatorContract
     * @param array $pageTemplates
     * @return array
     */
    public function generatorContract(array $pageTemplateParameters): array;
}