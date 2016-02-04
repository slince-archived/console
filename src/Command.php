<?php
namespace Slince\Console;

use Slince\Console\Helper\HelperInterface;
use Slince\Console\Context\Io;
use Slince\Console\Context\Argv;
use Slince\Console\Context\Definition;
use Slince\Console\Context\Argument;
use Slince\Console\Context\Option;

class Command implements CommandInterface
{

    /**
     * name
     * 
     * @var string
     */
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
    
    protected $description;

    /**
     * console
     *
     * @var Console
     */
    protected $console;

    function __construct()
    {
        $this->definition = new Definition();
        $this->help = new Help();
        $this->configure();
    }

    function setConsole(Console $console)
    {
        $this->console = $console;
    }

    function getName()
    {
        return $this->name;
    }

    function configure()
    {}

    function initialize(Io $io, Argv $argv)
    {}

    function execute(Io $io, Argv $argv)
    {}

    function run(Io $io, Argv $argv)
    {
        $this->initialize($io, $argv);
        $this->execute($io, $argv);
    }

    function addOption($name, $valueMode, $description = null, $default = null)
    {
        $this->definition->addOption(new Option($name, $valueMode, $description, $default));
        return $this;
    }

    function addArgument($name, $valueMode, $description = null, $default = null)
    {
        $this->definition->addArgument(new Argument($name, $valueMode, $description, $default));
        return $this;
    }

    function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }
    
    function getDescription()
    {
        return $this->description;
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