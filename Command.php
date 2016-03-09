<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */
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

    /**
     * (non-PHPdoc)
     * @see \Slince\Console\CommandInterface::setConsole()
     */
    function setConsole(Console $console)
    {
        $this->console = $console;
    }

    /**
     * (non-PHPdoc)
     * @see \Slince\Console\CommandInterface::getName()
     */
    function getName()
    {
        return $this->name;
    }


    /**
     * (non-PHPdoc)
     * @see \Slince\Console\CommandInterface::configure()
     */
    function configure()
    {}


    /**
     * (non-PHPdoc)
     * @see \Slince\Console\CommandInterface::initialize()
     */
    function initialize(Io $io, Argv $argv)
    {}

    /**
     * (non-PHPdoc)
     * @see \Slince\Console\CommandInterface::execute()
     */
    function execute(Io $io, Argv $argv)
    {}

    /**
     * 允许app
     * @param Io $io
     * @param Argv $argv
     */
    function run(Io $io, Argv $argv)
    {
        $this->initialize($io, $argv);
        $this->execute($io, $argv);
    }

    /**
     * 给command添加option
     * 
     * @param string $name
     * @param int $valueMode
     * @param string $description
     * @param string $default
     * @return \Slince\Console\Command
     */
    function addOption($name, $valueMode, $description = null, $default = null)
    {
        $this->definition->addOption(new Option($name, $valueMode, $description, $default));
        return $this;
    }

    /**
     * 给command添加argument
     * 
     * @param string $name
     * @param int $valueMode
     * @param string $description
     * @param string $default
     * @return \Slince\Console\Command
     */
    function addArgument($name, $valueMode, $description = null, $default = null)
    {
        $this->definition->addArgument(new Argument($name, $valueMode, $description, $default));
        return $this;
    }

    /**
     * 设置command的描述信息
     * 
     * @param string $description
     * @return \Slince\Console\Command
     */
    function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }
    
    /**
     * 获取command的描述信息
     * 
     * @return string
     */
    function getDescription()
    {
        return $this->description;
    }

    /**
     * 获取helper
     * 
     * @param string $name
     */
    function getHelper($name)
    {
        return $this->console->getHelperRegistry()->get($name);
    }

    /**
     * (non-PHPdoc)
     * @see \Slince\Console\CommandInterface::getDefinition()
     */
    function getDefinition()
    {
        return $this->definition;
    }

    /**
     * 注册一个helper
     * 
     * @param string $name
     * @param HelperInterface $helper
     */
    function registerHelper($name, HelperInterface $helper)
    {
        $this->console->getHelperRegistry()->register($name, $helper);
    }
}