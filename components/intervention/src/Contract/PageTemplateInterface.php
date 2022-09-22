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
     * setRenderParameters.
     */
    public function setRenderParameters(array $renderParameters): void;

    /**
     * getRenderParameters.
     */
    public function getRenderParameters(): array;

    /**
     * getTemplateUrl.
     */
    public function getTemplateUrl(): string;

    /**
     * setTemplateUrl.
     */
    public function setTemplateUrl(string $templateUrl): void;

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
     */
    public function save2Page();
}
