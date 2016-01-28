<?php
namespace Slince\Console\Helper;

class Helper implements HelperInterface
{
    protected $io;
    
    function __construct($io = null)
    {
        $this->io = $io;
    }
}