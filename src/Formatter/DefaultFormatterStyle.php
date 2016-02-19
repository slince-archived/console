<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Console\Formatter;

class DefaultFormatterStyle extends FormatterStyle
{

    function configureLabelStyle()
    {
        $this->getLabel('success')->setForegroundColor('green');
        $this->getLabel('error')->setForegroundColor('red');
        $this->getLabel('warning')->setForegroundColor('yellow');
        $this->getLabel('info')->setForegroundColor('default');
    }
}