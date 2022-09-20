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

use Pis0sion\Intervention\Exception\InvalidFontsException;

/**
 * \Pis0sion\Intervention\Fonts.
 */
class Fonts
{
    /**
     * @var string
     */
    protected string $fontUrl;

    /**
     * @var int
     */
    protected int $fontSize;

    /**
     * @var string
     */
    protected string $fontColor;

    /**
     * getFontUrl
     * @return string
     */
    public function getFontUrl(): string
    {
        return $this->fontUrl;
    }

    /**
     * setFontUrl
     * @param string $fontUrl
     */
    public function setFontUrl(string $fontUrl): void
    {
        $this->fontUrl = $fontUrl;
    }

    /**
     * getFontSize
     * @return int
     */
    public function getFontSize(): int
    {
        return $this->fontSize;
    }

    /**
     * setFontSize
     * @param int $fontSize
     */
    public function setFontSize(int $fontSize): void
    {
        $this->fontSize = $fontSize;
    }

    /**
     * getFontColor
     * @return string
     */
    public function getFontColor(): string
    {
        return $this->fontColor;
    }

    /**
     * setFontColor
     * @param string $fontColor
     */
    public function setFontColor(string $fontColor): void
    {
        $this->fontColor = $fontColor;
    }

    /**
     * setFontStyle.
     * @return \Closure
     */
    public function setFontStyle()
    {
        $this->fontUrl = config('intervention.fonts.fontUrl');
        $this->fontSize = config('intervention.fonts.fontSize', 40);
        $this->fontColor = config('intervention.fonts.fontColor', '#000000');
        try {
            return fn ($font) => $font->file($this->fontUrl)->size($this->fontSize)->color($this->fontColor);
        } catch (\Throwable) {
            throw new InvalidFontsException('The font file does not exist');
        }
    }
}
