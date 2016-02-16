<?php
namespace Slince\Console\Formatter;

use Slince\Console\Exception\InvalidArgumentException;

/**
 * 字背景颜色范围:40----49
 * 40:黑
 * 41:深红
 * 42:绿
 * 43:黄色
 * 44:蓝色
 * 45:紫色
 * 46:深绿
 * 47:白色
 *
 * 字颜色:30-----------39
 * 30:黑
 * 31:红
 * 32:绿
 * 33:黄
 * 34:蓝色
 * 35:紫色
 * 36:深绿
 * 37:白色
 *
 * \033[0m 关闭所有属性
 * \033[1m 设置高亮度
 * \033[4m 下划线
 * \033[5m 闪烁
 * \033[7m 反显
 * \033[8m 消隐
 * \033[30m 至 \33[37m 设置前景色
 * \033[40m 至 \33[47m 设置背景色
 * \033[nA 光标上移n行
 * \033[nB 光标下移n行
 * \033[nC 光标右移n行
 * \033[nD 光标左移n行
 * \033[y;xH设置光标位置
 * \033[2J 清屏
 * \033[K 清除从光标到行尾的内容
 * \033[s 保存光标位置
 * \033[u 恢复光标位置
 * \033[?25l 隐藏光标
 * \033[?25h 显示光标
 *
 * Usage:
 * 
 * $formatter = new Formatter();
 * $formatter->setBackgroundColor('blue');
 * $formatter->setForegroundColor('green');
 * $formatter->setFontStyles(['italic']);
 * echo $formatter->apply('hello world');
 */
class Formatter
{

    const ESC = "\033[";

    const ESC_SEQ_PATTERN = "\033[%sm";

    const RESET = 0;

    protected static $availableForegroundColors = [
        'black' => 30,
        'red' => 31,
        'green' => 32,
        'yellow' => 33,
        'blue' => 34,
        'magenta' => 35,
        'cyan' => 36,
        'white' => 37,
        'default' => 39
    ];

    protected static $availableBackgroundColors = [
        'black' => 40,
        'red' => 41,
        'green' => 42,
        'yellow' => 43,
        'blue' => 44,
        'magenta' => 45,
        'cyan' => 46,
        'white' => 47,
        'default' => 49
    ];

    protected static $availableFontStyles = [
        'bold' => 1,
        'dark' => 2,
        'italic' => 3,
        'underline' => 4,
        'blink' => 5,
        'reverse' => 7,
        'concealed' => 8
    ];

    protected $foregroundColor;

    protected $backgroundColor;

    protected $fontStyles = [];

    function setBackgroundColor($color)
    {
        if (! isset(self::$availableBackgroundColors[$color])) {
            throw new InvalidArgumentException(sprintf('Invalid background color specified: "%s". Expected one of (%s)', $color, implode(', ', array_keys(self::$availableBackgroundColors))));
        }
        $this->backgroundColor = self::$availableBackgroundColors[$color];
    }

    function setForegroundColor($color)
    {
        if (! isset(self::$availableForegroundColors[$color])) {
            throw new InvalidArgumentException(sprintf('Invalid foreground color specified: "%s". Expected one of (%s)', $color, implode(', ', array_keys(self::$availableForegroundColors))));
        }
        $this->foregroundColor = self::$availableForegroundColors[$color];
    }

    function setFontStyles($fontStyles)
    {
        $this->fontStyles = [];
        foreach ($fontStyles as $fontStyle) {
            $this->addFontStyle($fontStyle);
        }
    }

    function addFontStyle($fontStyle)
    {
        if (! isset(self::$availableFontStyles[$fontStyle])) {
            throw new InvalidArgumentException(sprintf('Invalid font style specified: "%s". Expected one of (%s)', $option, implode(', ', array_keys(static::$availableFontStyles))));
        }
        $this->fontStyles[] = self::$availableFontStyles[$fontStyle];
    }

    function apply($text)
    {
        $codes = [];
        if (! is_null($this->foregroundColor)) {
            $codes[] = $this->foregroundColor;
        }
        if (! is_null($this->backgroundColor)) {
            $codes[] = $this->backgroundColor;
        }
        $this->fontStyles = array_unique($this->fontStyles);
        foreach ($this->fontStyles as $fontStyle) {
            $codes[] = $fontStyle;
        }
        return sprintf(self::ESC_SEQ_PATTERN . '%s' . self::ESC_SEQ_PATTERN, implode(';', $codes), $text, self::RESET);
    }
}