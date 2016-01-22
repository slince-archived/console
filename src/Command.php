<?php
namespace Slince\Console;

class Command implements CommandInterface
{

    protected $name;

    protected $options = [];
    
    protected $arguments = [];
    
    /**
     * help
     * 
     * @var Help
     */
    protected $help;

    function getName()
    {
        return $this->name;
    }

    function execute(Stdio $io, Argv $argv)
    {
        trigger_error();
    }

    function addOption($name, $valueModel, $description = null, $default = null)
    {
        $this->options[] = new Option($name, $valueMode, $description, $default);
        return $this;
    }
    
    function addArgument($name, $valueModel, $description = null, $default = null)
    {
        $this->arguments[] = new Argument($name, $valueMode, $description, $default);
        return $this;
    }
    
    function setHelp(Help $help)
    {
        $this->help = $help;
    }
    
    function getHelp()
    {
        return $this->help;
    }
}