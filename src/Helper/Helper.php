<?php
namespace Slince\Console\Helper;

class Helper implements HelperInterface
{
    protected $io;
    
    function __construct($io)
    {
        $this->io = $io;
    }
}