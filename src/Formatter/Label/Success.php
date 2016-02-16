<?php
namespace Slince\Console\Formatter\Label;

class Success extends Label
{

    function getForegroundColor()
    {
        return 'green';
    }
}