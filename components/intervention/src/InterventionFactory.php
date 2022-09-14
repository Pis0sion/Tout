<?php

namespace Pis0sion\Intervention;

use Psr\Container\ContainerInterface;

/**
 * \Pis0sion\Intervention\InterventionFactory
 */
class InterventionFactory
{
    /**
     * __invoke
     */
    public function __invoke(ContainerInterface $container)
    {
        return $container->get(ContractTask::class);
    }
}