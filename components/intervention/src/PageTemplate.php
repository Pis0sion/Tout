<?php

namespace Pis0sion\Intervention;

use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Pis0sion\Intervention\Contract\PageTemplateInterface;
use Pis0sion\Intervention\Exception\InvalidPageUriException;

/**
 * \Pis0sion\Intervention\PageTemplate
 */
class PageTemplate implements PageTemplateInterface
{
    /**
     * @var \Intervention\Image\Image
     */
    protected Image $imageEntity;

    /**
     * @param string $templateUrl
     * @param array $renderParameters
     */
    public function __construct(protected string $templateUrl, protected array $renderParameters = [])
    {
        $this->setImageEntity(
            (make(ImageManager::class))->make($this->obtainResourcesFromRemoteURL($this->templateUrl))
        );
    }

    /**
     * @param \Intervention\Image\Image $imageEntity
     */
    public function setImageEntity(Image $imageEntity): void
    {
        $this->imageEntity = $imageEntity;
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
     * obtainResourcesFromRemoteURL
     * @param string $remoteUrl
     * @return false|string
     */
    protected function obtainResourcesFromRemoteURL(string $remoteUrl)
    {
        $contextOptions = ["ssl" => ["verify_peer" => false, "verify_peer_name" => false,]];

        if (!$fResource = @file_get_contents($remoteUrl, false, stream_context_create($contextOptions))) {
            throw new InvalidPageUriException("获取远程资源失败");
        }

        return $fResource;
    }

    /**
     * inputText2PageTemplate
     * @param array $renderParameter
     */
    public function inputText2PageTemplate(array $renderParameter)
    {
        $fontClosure = fn($font) => $font->file((BASE_PATH . '/fonts/simhei.ttf'))->size(40)->color('#000000');
        return $this->imageEntity->text($renderParameter['content'], $renderParameter['width'], $renderParameter['height'], $fontClosure);
    }

    /**
     * insertImageResource2PageTemplate
     * @param array $renderParameter
     */
    public function insertImageResource2PageTemplate(array $renderParameter)
    {
        $insertResource = $this->obtainResourcesFromRemoteURL($renderParameter["content"]);
        return $this->imageEntity->insert($insertResource, 'top-left', $renderParameter['width'], $renderParameter['height']);
    }

    /**
     * save2Page
     * @return string
     */
    public function save2Page()
    {
        $fileName = md5(uniqid() . microtime(true)) . ".png";
        //$this->imageEntity->save(BASE_PATH . '/runtime/' . $fileName);
        \Swoole\Coroutine\System::writeFile(BASE_PATH . '/runtime/' . $fileName, $this->imageEntity->encode()->getEncoded());
        return $fileName;
    }

}