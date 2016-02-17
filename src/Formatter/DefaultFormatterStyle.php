<?php
namespace Slince\Console\Formatter;

class DefaultFormatterStyle extends FormatterStyle
{

    function configureLabelStyle()
    {
        $this->getLabel('success')->getForegroundColor('green');
        $this->getLabel('error')->getForegroundColor('red');
        $this->getLabel('warning')->getForegroundColor('yellow');
        $this->getLabel('info')->getForegroundColor('default');
    }
}