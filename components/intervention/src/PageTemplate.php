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

namespace Pis0sion\Intervention;

use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Pis0sion\Intervention\Contract\PageTemplateInterface;
use Pis0sion\Intervention\Exception\InvalidPageUriException;
use Swoole\Coroutine\System;

/**
 * \Pis0sion\Intervention\PageTemplate.
 */
class PageTemplate implements PageTemplateInterface
{
    /**
     * @var \Intervention\Image\Image
     */
    protected Image $imageEntity;

    /**
     * __invoke.
     */
    public function __construct(protected string $templateUrl, protected array $renderParameters = [])
    {
        $this->imageEntity = make(ImageManager::class)->make($this->obtainResourcesFromRemoteURL($this->templateUrl));
    }

    /**
     * getTemplateUrl
     * @return string
     */
    public function getTemplateUrl(): string
    {
        return $this->templateUrl;
    }

    /**
     * setTemplateUrl
     * @param string $templateUrl
     */
    public function setTemplateUrl(string $templateUrl): void
    {
        $this->templateUrl = $templateUrl;
    }

    /**
     * getRenderParameters
     * @return array
     */
    public function getRenderParameters(): array
    {
        return $this->renderParameters;
    }

    /**
     * setRenderParameters
     * @param array $renderParameters
     */
    public function setRenderParameters(array $renderParameters): void
    {
        $this->renderParameters = $renderParameters;
    }

    /**
     * inputText2PageTemplate.
     */
    public function inputText2PageTemplate(array $renderParameter)
    {
        $fontClosure = fn($font) => $font->file(BASE_PATH . '/config/autoload/simhei.ttf')->size(40)->color('#000000');
        return $this->imageEntity->text($renderParameter['content'], $renderParameter['width'], $renderParameter['height'], $fontClosure);
    }

    /**
     * insertImageResource2PageTemplate.
     */
    public function insertImageResource2PageTemplate(array $renderParameter)
    {
        $insertResource = $this->obtainResourcesFromRemoteURL($renderParameter['content']);
        return $this->imageEntity->insert($insertResource, 'top-left', $renderParameter['width'], $renderParameter['height']);
    }

    /**
     * save2Page
     * override this method to implement different save rules.
     * @return string
     */
    public function save2Page()
    {
        $fileName = md5(uniqid() . microtime(true)) . '.jpg';
        // @notice code that blocks using io is prohibited
        System::writeFile(BASE_PATH . '/runtime/' . $fileName, $this->imageEntity->encode()->getEncoded());
        return $fileName;
    }

    /**
     * obtainResourcesFromRemoteURL.
     * @return false|string
     */
    protected function obtainResourcesFromRemoteURL(string $remoteUrl)
    {
        $contextOptions = ['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]];

        if (!$fResource = @file_get_contents($remoteUrl, false, stream_context_create($contextOptions))) {
            throw new InvalidPageUriException('failed to get remote resource');
        }

        return $fResource;
    }

}
