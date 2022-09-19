<?php

namespace Pis0sion\Intervention\Contract;


/**
 * \Pis0sion\Intervention\Contract\PageTemplateInterface
 */
interface PageTemplateInterface
{

    /**
     * inputText2PageTemplate
     * @param array $renderParameter
     */
    public function inputText2PageTemplate(array $renderParameter);

    /**
     * insertImageResource2PageTemplate
     * @param array $renderParameter
     */
    public function insertImageResource2PageTemplate(array $renderParameter);

    /**
     * save2Page
     * @return mixed
     */
    public function save2Page();
}