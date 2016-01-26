<?php
namespace Slince\Console;

use Slince\Console\Helper\HelperInterface;

use Slince\Console\Context\Io;
use Slince\Console\Context\Argv;
use Slince\Console\Context\Definition;

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
    
    function __construct()
    {
        $this->definition = new Definition();
    }

    function setConsole(Console $console)
    {
        $this->console = $console;
    }

    function getName()
    {
        return $this->name;
    }

    function initialize(Io $io, Argv $argv)
    {
    }
    function execute(Io $io, Argv $argv)
    {
        $this->initialize($io, $argv);
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