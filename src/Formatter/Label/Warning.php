<?php
namespace Slince\Console\Formatter\Label;

class Warning extends Label
{

    function getForegroundColor()
    {
        return 'yellow';
    }
}