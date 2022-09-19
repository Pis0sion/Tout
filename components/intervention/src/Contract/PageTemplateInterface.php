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
namespace Pis0sion\Intervention\Contract;

/**
 * \Pis0sion\Intervention\Contract\PageTemplateInterface.
 */
interface PageTemplateInterface
{
    /**
     * inputText2PageTemplate.
     */
    public function inputText2PageTemplate(array $renderParameter);

    /**
     * insertImageResource2PageTemplate.
     */
    public function insertImageResource2PageTemplate(array $renderParameter);

    /**
     * save2Page.
     * @return mixed
     */
    public function save2Page();
}
