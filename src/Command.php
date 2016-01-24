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

    protected $options = [];

    protected $arguments = [];

    /**
     * help
     *
     * @var Help
     */
    protected $help;

    function init();

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

    function getHelper($name)
    {
        return $this->console->getHelperRegistry()->get($name);
    }
    
    function registerHelper($name, HelperInterface $helper)
    {
        $this->console->getHelperRegistry()->register($name, $helper);
    }
}