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
namespace Pis0sion\Intervention;

use Pis0sion\Intervention\Contract\ContractGeneratorFactoryInterface;
use Pis0sion\Intervention\Contract\PageTemplateInterface;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                ContractGeneratorFactoryInterface::class => ContractGenerator::class,
                PageTemplateInterface::class => PageTemplate::class,
            ],
            'commands' => [
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
        ];
    }
}
