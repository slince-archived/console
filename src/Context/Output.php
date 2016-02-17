<?php
namespace Slince\Console\Context;

use Slince\Console\Formatter\FormatterStyle;
use Slince\Console\Formatter\DefaultFormatterStyle;

class Output
{

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

    function setFormatterStyle(FormatterStyle $formatterStyle)
    {
        $this->formatterStyle = $formatterStyle;
    }
    
    function getFormatterStyle()
    {
        return $this->formatterStyle;
    }
    
    function write($message, $newLine = false)
    {
        $message = $this->formatterStyle->stylize($message);
        if ($newLine) {
            $message .= PHP_EOL;
        }
        return fwrite($this->stream, $message);
    }
}