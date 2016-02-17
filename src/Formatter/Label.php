<?php
namespace Slince\Console\Formatter;

class Label
{

    protected $foregroundColor;

    protected $backgroundColor;

    protected $fontStyles = [];

    function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }

    function setForegroundColor($foregroundColor)
    {
        $this->foregroundColor = $foregroundColor;
    }

    function setFontStyles(array $fontStyles)
    {
        $this->fontStyles = $fontStyles;
    }

    function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    function getForegroundColor()
    {
        return $this->foregroundColor;
    }

    function getFontStyles()
    {
        return $this->fontStyles;
    }
}