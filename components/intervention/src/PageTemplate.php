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
    protected Image $imageEntity;

    /**
     * @var \Pis0sion\Intervention\Fonts
     */
    protected Fonts $fonts;

    /**
     * __invoke.
     */
    public function __construct(protected string $templateUrl, protected array $renderParameters = [])
    {
        $driver = config('intervention.driver', 'gd');
        $this->fonts = make(Fonts::class);
        $this->imageEntity = make(ImageManager::class, compact('driver'))->make($this->obtainResourcesFromRemoteURL($this->templateUrl));
    }

    /**
     * getTemplateUrl.
     */
    public function getTemplateUrl(): string
    {
        return $this->templateUrl;
    }

    /**
     * setTemplateUrl.
     */
    public function setTemplateUrl(string $templateUrl): void
    {
        $this->templateUrl = $templateUrl;
    }

    /**
     * getRenderParameters.
     */
    public function getRenderParameters(): array
    {
        return $this->renderParameters;
    }

    /**
     * setRenderParameters.
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
        return $this->imageEntity->text($renderParameter['content'], $renderParameter['width'], $renderParameter['height'], $this->fonts->setFontStyle());
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
    public function save2Page(string $fileName = ""): string
    {
        if ($fileName == "")
            $fileName = $this->getDefaultFileName();

        // @notice code that blocks using io is prohibited
        System::writeFile($fileName, $this->imageEntity->encode()->getEncoded());
        return $fileName;
    }

    /**
     * getDefaultFileName
     * @return string
     */
    protected function getDefaultFileName(): string
    {
        return md5(uniqid() . microtime(true)) . '.jpg';
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
