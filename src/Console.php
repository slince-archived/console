<?php
namespace Slince\Console;

use Slince\Console\Commend\CommendInterface;
use Slince\Console\Context\Io;
use Slince\Console\Context\Argv;
use Slince\Console\Context\Input;
use Slince\Console\Context\Output;
use Slince\Console\Context\Definition;
use Slince\Console\Context\Option;

class Console
{

    protected $commands = [];

    /**
     * stdio
     *
     * @var Io
     */
    protected $io;

    /**
     * argv
     *
     * @var Argv
     */
    protected $argv;
    
    /**
     * helper registery
     *
     * @var HelperRegistery
     */
    protected $helperRegistry;

    function __construct(Io $io = null, HelperRegistry $helperRegistry = null)
    {
        if (is_null($io)) {
            $io = new Io(new Input(), new Output(), new Output('php://stderr'));
        }
        if (is_null($helperRegistry)) {
            $helperRegistry = new HelperRegistry($this);
        }
        $this->helperRegistry = $helperRegistry;
        $this->io = $io;
    }

    function getHelperRegistry()
    {
        return $this->helperRegistry;
    }
    
    function addCommand(CommandInterface $command)
    {
        $command->setConsole($this);
        $this->commands[$command->getName()] = $command;
    }

    function run(Argv $argv = null)
    {
        if (is_null($argv)) {
            $argv = new Argv($_SERVER['argv']);
        }
        $this->argv = $argv;
        $name = $this->getCommandName();
        if ($argv->hasOptionParameter(['-h', '--help'])) {
            $this->addCommand(new HelpCommand());
            $this->argv->addArgument('command_name', $name);
            $name = 'help';
        }
        $command = $this->find($name);
        $this->runCommand($command);
    }

    function runCommand(CommandInterface $command)
    {
        $this->argv->bind($command->getDefinition()->merge($this->getDefaultDefinition()));
        return $command->execute($this->io, $this->argv);
    }
    
    function getCommandName()
    {
        return $this->argv->getFirstArgument();
    }
    
    function find($name)
    {
        if (isset($this->commands[$name])) {
            return $this->commands[$name];
        }
    }
    
    function getDefaultDefinition()
    {
        return new Definition([
            new Option('h', Option::VALUE_NONE),
            new Option('help', Option::VALUE_NONE)
        ]);
    }
    
    function getIo()
    {
        return $this->io;
    }
    
    function isWin()
    {
        return preg_match('/win/i', PHP_OS);
    }
    
    function clear()
    {
        $this->isWin() ? shell_exec('cls') : shell_exec('clear');
    }
}