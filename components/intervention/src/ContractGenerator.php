<?php

namespace Pis0sion\Intervention;

use Pis0sion\Intervention\Contract\ContractGeneratorFactoryInterface;
use Pis0sion\Intervention\Exception\InvalidKeyValueException;

/**
 * \Pis0sion\Intervention\ContractGenerator
 */
class ContractGenerator implements ContractGeneratorFactoryInterface
{
    /**
     * contractTemplateFactory
     * @return \Pis0sion\Intervention\ContractTemplateFactory
     */
    protected function contractTemplateFactory()
    {
        return new ContractTemplateFactory();
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

            if (!array_key_exists("templateUrl", $pageTemplateParameter) ||
                !array_key_exists("content", $pageTemplateParameter)) {
                throw new InvalidKeyValueException("无效的键值对");
            }

            $pageTemplates[$page] = fn() => new PageTemplate($pageTemplateParameter["templateUrl"], $pageTemplateParameter["content"]);
        }

        return parallel($pageTemplates);
    }

    /**
     * generatorContract
     * @param array $pageTemplates
     * @return array
     */
    public function generatorContract(array $pageTemplateParameters): array
    {
        $pageTemplates = $this->build2PageTemplate($pageTemplateParameters);
        $contractTemplateFactory = $this->contractTemplateFactory();

        foreach ($pageTemplates as $page => $pageTemplate) {
            $contractTemplateFactory->addPageTemplates($page, $pageTemplate);
        }

        return $contractTemplateFactory->renderContractTemplate();
    }
}