<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Console\Context;

use Slince\Console\Formatter\FormatterStyle;
use Slince\Console\Formatter\DefaultFormatterStyle;

class Output
{

    /**
     * 输出流
     * 
     * @var resource
     */
    protected $stream;
    
    /**
     * formatter style
     * 
     * @var FormatterStyle
     */
    protected $formatterStyle;

    function __construct($handle = 'php://stdout', $mode = null, FormatterStyle $formatterStyle = null)
    {
        if (is_null($mode)) {
            $model = 'w';
        }
        if (is_null($formatterStyle)) {
            $formatterStyle = new DefaultFormatterStyle();
        }
        $this->setFormatterStyle($formatterStyle);
        $this->stream = fopen($handle, $model);
    }

    /**
     * 设置格式化样式
     * 
     * @param FormatterStyle $formatterStyle
     */
    function setFormatterStyle(FormatterStyle $formatterStyle)
    {
        $this->formatterStyle = $formatterStyle;
    }
    
    /**
     * 获取格式化样式
     * 
     * @return \Slince\Console\Formatter\FormatterStyle
     */
    function getFormatterStyle()
    {
        return $this->formatterStyle;
    }
    
    /**
     * 写消息
     * 
     * @param string $message
     * @param boolean $newLine
     * @return number
     */
    function write($message, $newLine = false)
    {
        $message = $this->formatterStyle->stylize($message);
        if ($newLine) {
            $message .= PHP_EOL;
        }
        return fwrite($this->stream, $message);
    }
}