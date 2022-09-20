<?php

namespace Pis0sion\Intervention;

use Pis0sion\Intervention\Exception\InvalidFontsException;

/**
 * \Pis0sion\Intervention\Fonts
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
     * @return string
     */
    public function getFontUrl(): string
    {
        return $this->fontUrl;
    }

    /**
     * @param string $fontUrl
     */
    public function setFontUrl(string $fontUrl): void
    {
        $this->fontUrl = $fontUrl;
    }

    /**
     * @return int
     */
    public function getFontSize(): int
    {
        return $this->fontSize;
    }

    /**
     * @param int $fontSize
     */
    public function setFontSize(int $fontSize): void
    {
        $this->fontSize = $fontSize;
    }

    /**
     * @return string
     */
    public function getFontColor(): string
    {
        return $this->fontColor;
    }

    /**
     * @param string $fontColor
     */
    public function setFontColor(string $fontColor): void
    {
        $this->fontColor = $fontColor;
    }

    /**
     * setFontStyle
     * @return \Closure
     */
    public function setFontStyle()
    {
        $this->fontUrl = config('intervention.fonts.fontUrl');
        $this->fontSize = config('intervention.fonts.fontSize', 40);
        $this->fontColor = config('intervention.fonts.fontColor', '#000000');
        try {
            return fn($font) => $font->file($this->fontUrl)->size($this->fontSize)->color($this->fontColor);
        } catch (\Throwable) {
            throw new InvalidFontsException("The font file does not exist");
        }
    }
}