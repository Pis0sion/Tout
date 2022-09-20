<?php

namespace Pis0sion\Intervention;

/**
 * \Pis0sion\Intervention\Fonts
 */
class Fonts
{
    /**
     * @param string $fontUrl
     * @param int $fontSize
     * @param string $fontColor
     */
    public function __construct(protected string $fontUrl, protected int $fontSize = 16, protected string $fontColor = '#000000')
    {
        $this->fontUrl = config("intervention.fonts.fontUrl") ?? $this->fontUrl;
        $this->fontSize = config("intervention.fonts.fontSize") ?? $this->fontSize;
        $this->fontColor = config("intervention.fonts.fontColor") ?? $this->fontColor;
    }

    /**
     * setFontStyle
     * @return \Closure
     */
    public function setFontStyle()
    {
        return fn($font) => $font?->file($this->fontUrl)?->size($this->fontSize)?->color($this->fontColor);
    }

}