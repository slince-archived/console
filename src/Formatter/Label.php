<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Console\Formatter;

class Label
{

    /**
     * 当前前景色
     * 
     * @var string
     */
    protected $foregroundColor;

    /**
     * 当前背景色
     * 
     * @var string
     */
    protected $backgroundColor;

    /**
     * 当前字体风格
     * 
     * @var array
     */
    protected $fontStyles = [];

    /**
     * 设置背景色
     *
     * @param string $color
     */
    function setBackgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;
    }
    /**
     * 设置前景色
     *
     * @param string $color
     */
    function setForegroundColor($foregroundColor)
    {
        $this->foregroundColor = $foregroundColor;
    }

    /**
     * 设置字体风格
     *
     * @param array $fontStyles
     */
    function setFontStyles(array $fontStyles)
    {
        $this->fontStyles = $fontStyles;
    }

    /**
     * 获取背景色
     *
     * @param string $color
     */
    function getBackgroundColor()
    {
        return $this->backgroundColor;
    }

    /**
     * 获取前景色
     *
     * @param string $color
     */
    function getForegroundColor()
    {
        return $this->foregroundColor;
    }

    /**
     * 获取字体风格
     *
     * @param array $fontStyles
     */
    function getFontStyles()
    {
        return $this->fontStyles;
    }
}