<?php
namespace Slince\Console;

class Argv
{
    protected $argv = [];
    
    protected $arguments = [];
    
    protected $options = [];
    
    function __construct($argv)
    {
        $this->argv = $argv;
    }
    
    function shift()
    {
        
    }
    
    function parse();
}