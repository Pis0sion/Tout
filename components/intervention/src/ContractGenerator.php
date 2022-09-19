<?php

namespace Pis0sion\Intervention;

use Hyperf\Utils\Collection;
use Pis0sion\Intervention\Contract\ContractGeneratorFactoryInterface;
use Pis0sion\Intervention\Contract\PageTemplateInterface;
use Pis0sion\Intervention\Exception\InvalidKeyValueException;

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

            if (!array_key_exists("templateUrl", $pageTemplateParameter) ||
                !array_key_exists("content", $pageTemplateParameter)) {
                throw new InvalidKeyValueException("无效的键值对");
            }

            $pageTemplates[$page] = fn() => make(PageTemplateInterface::class, $pageTemplateParameter);
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
        $this->contractTemplateFactory->setPageTemplates((new Collection()));

        foreach ($pageTemplates as $page => $pageTemplate) {
            $this->contractTemplateFactory->addPageTemplates($page, $pageTemplate);
        }

        return $this->contractTemplateFactory->renderContractTemplate();
    }

}