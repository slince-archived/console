<?php
namespace Slince\Console;

use Slince\Console\Helper\HelperInterface;

class Command implements CommandInterface
{

    /**
     * console
     *
     * @var Console
     */
    protected $console;

    protected $name;

    /**
     * help
     *
     * @var Help
     */
    protected $help;

    /**
     * Definition
     *
     * @var Definition
     */
    protected $definition;

    function init();
    
    function setConsole(Console $console)
    {
        $this->console = $console;
    }

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
        $this->definition->addOption(new Option($name, $valueMode, $description, $default));
        return $this;
    }

    function addArgument($name, $valueModel, $description = null, $default = null)
    {
        $this->definition->addArgument(new Argument($name, $valueMode, $description, $default));
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

    function getHelper($name)
    {
        return $this->console->getHelperRegistry()->get($name);
    }

    function getDefinition()
    {
        return $this->definition;
    }

    function registerHelper($name, HelperInterface $helper)
    {
        $this->console->getHelperRegistry()->register($name, $helper);
    }
}