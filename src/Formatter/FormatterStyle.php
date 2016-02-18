<?php
namespace Slince\Console\Formatter;

use Slince\Console\Exception\InvalidArgumentException;
use Slince\Console\Formatter\Label;

abstract class FormatterStyle
{

    protected static $registerLabels = [
        'success' => '\\Slince\\Console\\Formatter\\Label',
        'error' => '\\Slince\\Console\\Formatter\\Label',
        'warning' => '\\Slince\\Console\\Formatter\\Label',
        'info' => '\\Slince\\Console\\Formatter\\Label'
    ];

    protected $labels;
    
    protected $formatter;

    function __construct()
    {
        $this->formatter = new Formatter();
        $this->configureLabelStyle();
    }

    protected static function registerLabel($name, $className)
    {
        self::$registerLabels[$name] = $className;
    }

    /**
     * 获取标签
     *
     * @param strng $name
     * @throws InvalidArgumentException
     * @return Label
     */
    function getLabel($name)
    {
        if (isset($this->labels[$name])) {
            return $this->labels[$name];
        }
        if (! isset(self::$registerLabels[$name])) {
            throw new InvalidArgumentException(sprintf('Invalid label specified: "%s". Expected one of (%s)', $name, implode(', ', array_keys(self::$registerLabels))));
        }
        return $this->labels[$name] = new self::$registerLabels[$name]();
    }

    function createLabel($name)
    {
        return $this->labels[$name] = new Label();
    }

    function getAvaliableLabels()
    {
        return array_keys(self::$registerLabels) +
            array_keys($this->labels);
    }
    
    function applyLabelStyle($name, $message)
    {
        $label = $this->getLabel($name);
        $this->formatter->resetStyle();
        if (($color = $label->getBackgroundColor()) != null) {
            $this->formatter->setBackgroundColor($color);
        }
        if (($color = $label->getForegroundColor()) != null) {
            $this->formatter->setForegroundColor($color);
        }
        if ($fontStyles = $label->getFontStyles()) {
            $this->formatter->setFontStyles($fontStyles);
        }
        return $this->formatter->apply($message);
    }

    /*
     * 如果上一个是开标签,则下一个遇到的标签只能上一个标签的闭合标签或者是另外一个开标签
    * 如果上一个标签是闭合标签，则下一个标签只能是开标签或者另外一个标签的闭合标签
    *  I say <success>hello <info>world</info>!</success> ha ha
    *  错误的做法：
    *  I say <success>hello <info>world<info>!</info></info></success> ha ha
    *  <success>hello <success>world</success></success>
    *  <success>hello <info>world</success></info>
    *  'ha<success>Whats <info>your</info> name:</success>ha'
    */
    function stylize($message)
    {
        $tagRegex = implode('|', $this->getAvaliableLabels());
        preg_match_all("#<(($tagRegex) | /($tagRegex)?)>#ix", $message, $matches, PREG_OFFSET_CAPTURE);
        $processedMessage = '';
        $start = 0; //字符串本次处理的开始偏移量
        $lastLabel = false; //上一个标签名
        $lastLabelOpen = false; //上一个标签是否是开标签
        foreach ($matches[0] as $key => $match) {
            $pos = $match[1]; //当前标签的偏移量
            $currentLabelClose = $matches[1][$key][0]{0} == '/'; //当前标签闭合
            $currentLabel = ltrim($matches[1][$key][0], '/');  //当前标签名
            //如果没有上一个标签或者之前的标签已经完成闭合
            if ($lastLabel === false) {
                /*
                 * 如果当前标签是闭合标签，则将开始偏移位置到本标签的偏移位置的字符应用成当前闭合标签的样式
                 * 并且完成所有标签的闭合工作
                 */
                if ($currentLabelClose) {
                    $processedMessage .= $this->applyLabelStyle($currentLabel, substr($message, $start, $pos - $start));
                    $lastLabel = false;
                    $lastLabelOpen = false;
                    $start = $pos + strlen($match[0]);
                } else {
                    /*
                     * 如果当前标签是个开标签，那么开始偏移位置到本标签的偏移位置的字符串不应用样式
                     * 本标签更新成上个标签
                     */
                    $processedMessage .= substr($message, $start, $pos - $start);
                    $lastLabel = $matches[1][$key][0];
                    $lastLabelOpen = $lastLabel{0} != '/';
                    $lastLabel = ltrim($lastLabel, '/');
                    $start = $pos + strlen($match[0]);
                }
            } else { //如果上个标签存在
                //如果上个标签是开标签
                if ($lastLabelOpen) {
                    //如果本标签是关闭的并且和上个标签一样，应用当前标签样式，并且完成标签闭合
                    if ($currentLabelClose && $lastLabel == $currentLabel) {
                        $processedMessage .= $this->applyLabelStyle($currentLabel, substr($message, $start, $pos - $start));
                        $lastLabel = false;
                        $lastLabelOpen = false;
                        $start = $pos + strlen($match[0]);
                    }
                    if (! $currentLabelClose) {
                        $processedMessage .= $this->applyLabelStyle($lastLabel, substr($message, $start, $pos - $start));
                        $lastLabel = $matches[1][$key][0];
                        $lastLabelOpen = $lastLabel{0} != '/';
                        $lastLabel = ltrim($lastLabel, '/');
                        $start = $pos + strlen($match[0]);
                    }
                } else {
                    if ($currentLabelClose) {
                        $processedMessage .= $this->applyLabelStyle($currentLabel, substr($message, $start, $pos - $start));
                        $lastLabel = false;
                        $lastLabelOpen = false;
                        $start += strlen($match[0]);
                    } else {
                        $lastLabel = $matches[1][$key][0];
                        $lastLabelOpen = $lastLabel{0} != '/';
                        $lastLabel = ltrim($lastLabel, '/');
                        $start = $pos + strlen($match[0]);
                    }
                }
            }
        }
        $processedMessage .= substr($message, $start, strlen($message) - $start);
        echo $processedMessage;exit;
        return $processedMessage;
    }
    abstract function configureLabelStyle();
}