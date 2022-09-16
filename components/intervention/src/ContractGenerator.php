<?php

namespace Pis0sion\Intervention;

use Pis0sion\Intervention\Contract\ContractGeneratorFactoryInterface;

/**
 * \Pis0sion\Intervention\ContractGenerator
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
     * build2PageTemplate
     * @param array $pageTemplateParameters
     * @return array
     */
    protected function build2PageTemplate(array $pageTemplateParameters)
    {
        $pageTemplates = [];

        foreach ($pageTemplateParameters as $page => $pageTemplateParameter) {
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

        foreach ($pageTemplates as $page => $pageTemplate) {
            $this->contractTemplateFactory->addPageTemplates($page, $pageTemplate);
        }

        return $this->contractTemplateFactory->renderContractTemplate();
    }
}