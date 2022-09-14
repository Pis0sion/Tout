<?php

namespace Pis0sion\Intervention;

use Hyperf\Task\Annotation\Task;

/**
 * \Pis0sion\Intervention\ContractTask
 */
class ContractTask
{
    /**
     * handleRenderContract
     * @param \Pis0sion\Intervention\ContractPageTemplate $pageTemplate
     */
    #[Task(workerId: -1)]
    public function handleRenderContract(ContractPageTemplate $pageTemplate)
    {
        $pageTemplate->renderPageTemplate();
    }
}