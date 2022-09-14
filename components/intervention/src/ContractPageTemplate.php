<?php

namespace Pis0sion\Intervention;

use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Pis0sion\Intervention\Contract\ContractTemplateInterface;

/**
 * \Pis0sion\Intervention\ContractPageTemplate
 */
class ContractPageTemplate implements ContractTemplateInterface
{

    /**
     * @var \Intervention\Image\Image
     */
    protected Image $imageEntity;

    /**
     * @param string $templateUrl
     * @param array $renderParameters
     */
    public function __construct(protected string $templateUrl, protected array $renderParameters)
    {
        $this->imageEntity = make(ImageManager::class)->make($this->obtainResourcesFromRemoteURL($this->templateUrl));
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
        array_map($this->multiRender2PageTemplate(), $this->renderParameters);
        $fileName = md5(microtime(true) . uniqid()) . '.jpg';
        $this->imageEntity->save(BASE_PATH . "/runtime/" . $fileName);
    }

    /**
     * multiRender2PageTemplate
     * @return \Closure
     */
    protected function multiRender2PageTemplate()
    {
        return fn($renderParameter) => match ($renderParameter["type"]) {
            MimeType::TEXT_TYPE => $this->inputText2PageTemplate($renderParameter),
            MimeType::IMAGE_TYPE => $this->insertImageResource2PageTemplate($renderParameter),
            default => throw new \RuntimeException(),
        };
    }

    /**
     * obtainResourcesFromRemoteURL
     * @param string $remoteUrl
     * @return false|string
     */
    protected function obtainResourcesFromRemoteURL(string $remoteUrl)
    {
        $contextOptions = ["ssl" => ["verify_peer" => false, "verify_peer_name" => false,]];
        return file_get_contents($remoteUrl, false, stream_context_create($contextOptions));
    }

    /**
     * inputText2PageTemplate
     * @param array $renderParameter
     */
    protected function inputText2PageTemplate(array $renderParameter)
    {
        $fontClosure = fn($font) => $font->file((BASE_PATH . '/fonts/simhei.ttf'))->size(40)->color('#000000');
        return $this->imageEntity->text($renderParameter['content'], $renderParameter['width'], $renderParameter['height'], $fontClosure);
    }

    /**
     * insertImageResource2PageTemplate
     * @param array $renderParameter
     */
    protected function insertImageResource2PageTemplate(array $renderParameter)
    {
        $insertResource = $this->obtainResourcesFromRemoteURL($renderParameter["content"]);
        return $this->imageEntity->insert($insertResource, 'top-left', $renderParameter['width'], $renderParameter['height']);
    }
}