<?php
namespace Slince\Console;

class Command implements CommandInterface
{

    protected $name;
    
    protected $options = [];
    
    function getName()
    {
        return $this->name;
    }
    
    function execute(Stdio $io, Argv $argv)
    {
        trigger_error();
    }
    
    function addOption($name, $isRequire, $description)
    {
        
    }
}