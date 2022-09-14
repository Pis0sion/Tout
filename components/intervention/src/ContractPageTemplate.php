<?php

namespace Pis0sion\Intervention;

use Intervention\Image\Facades\Image;
use Pis0sion\Intervention\Contract\ContractTemplateInterface;
use \Intervention\Image\Image as InterventionImage;

/**
 * \Pis0sion\Intervention\ContractPageTemplate
 */
class ContractPageTemplate implements ContractTemplateInterface
{
    /**
     * @var \Intervention\Image\Image
     */
    protected InterventionImage $imageEntity;

    /**
     * @param string $templateUrl
     * @param array $renderParameters
     */
    public function __construct(public string $templateUrl = "", public array $renderParameters = [])
    {
    }

    /**
     * @return string
     */
    public function getTemplateUrl(): string
    {
        return $this->templateUrl;
    }

    /**
     * @param string $templateUrl
     */
    public function setTemplateUrl(string $templateUrl): void
    {
        $this->templateUrl = $templateUrl;
    }

    /**
     * @return array
     */
    public function getRenderParameters(): array
    {
        return $this->renderParameters;
    }

    /**
     * @param array $renderParameters
     */
    public function setRenderParameters(array $renderParameters): void
    {
        $this->renderParameters = $renderParameters;
    }

    /**
     * renderPageTemplate
     * @return mixed|void
     */
    public function renderPageTemplate(): void
    {
        $this->imageEntity = Image::make($this->templateUrl);

        foreach ($this->renderParameters as $renderParameter) {
            $this->imageEntity->text($renderParameter['content'], $renderParameter['width'], $renderParameter['height'], function ($font) {
                $font->file((BASE_PATH . '/fonts/simhei.ttf'));
            });
        }

        $this->imageEntity->save(BASE_PATH . '/runtime/result.jpg')->destroy();
    }
}