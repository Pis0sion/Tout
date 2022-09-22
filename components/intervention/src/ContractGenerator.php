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
use Pis0sion\Intervention\Exception\InvalidKeyValueException;

/**
 * \Pis0sion\Intervention\ContractGenerator.
 */
class ContractGenerator implements ContractGeneratorFactoryInterface
{
    /**
     * @var \Pis0sion\Intervention\ContractTemplateFactory
     */
    protected ContractTemplateFactory $contractTemplateFactory;

    /**
     * @param \Pis0sion\Intervention\ContractTemplateFactory $contractTemplateFactory
     */
    public function __construct(ContractTemplateFactory $contractTemplateFactory)
    {
        $this->contractTemplateFactory = $contractTemplateFactory;
    }

    /**
     * generatorContract
     * @param array $pageTemplateParameters
     * @return array
     */
    public function generatorContract(array $pageTemplateParameters): array
    {
        $pageTemplates = $this->build2PageTemplate($pageTemplateParameters);

        foreach ($pageTemplates as $page => $pageTemplate) {
            $this->contractTemplateFactory->addPageTemplates($page, $pageTemplate);
        }

        return $this->contractTemplateFactory->renderContractTemplate();
    }

    /**
     * build2PageTemplate
     * @param array $pageTemplateParameters
     * @return array
     */
    protected function build2PageTemplate(array $pageTemplateParameters)
    {
        $pageTemplates = [];

        foreach ($pageTemplateParameters as $page => $pageTemplateParameter) {
            if (! array_key_exists('templateUrl', $pageTemplateParameter)
                || ! array_key_exists('renderParameters', $pageTemplateParameter)) {
                throw new InvalidKeyValueException('invalid key-value pair');
            }

            $pageTemplates[$page] = fn () => make(PageTemplateInterface::class, $pageTemplateParameter);
        }

        return parallel($pageTemplates);
    }
}
