<?php

namespace Pis0sion\Intervention;

use Hyperf\Task\Annotation\Task;
use Pis0sion\Intervention\Contract\ContractTemplateInterface;

/**
 * \Pis0sion\Intervention\ContractTask
 */
class ContractTask
{

    /**
     * handleRenderContract
     * @param \Pis0sion\Intervention\Contract\ContractTemplateInterface $pageTemplate
     */
    #[Task(workerId: -1)]
    public function handleRenderContract(ContractTemplateInterface $pageTemplate)
    {
        $pageTemplate->renderPageTemplate();
    }
}