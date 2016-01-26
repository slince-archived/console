<?php
namespace Slince\Console;

use Slince\Console\Commend\CommendInterface;
use Slince\Console\Context\Io;
use Slince\Console\Context\Argv;
use Slince\Console\Context\Input;
use Slince\Console\Context\Output;

class Console
{

    protected $commends = [];

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
            $helperRegistry = new HelperRegistry();
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
        $this->commends[$command->getName()] = $command;
    }

    function run(Argv $argv = null)
    {
        if (is_null($argv)) {
            $argv = new Argv($_SERVER['argv']);
        }
        $this->argv = $argv;
        $name = $this->getCommandName();
        if (isset($this->commends[$name])) {
            $this->runCommand($this->commends[$name]);
        }
    }

    function runCommand(CommandInterface $command)
    {
        $this->argv->bind($command->getDefinition());
        return $command->execute($this->io, $this->argv);
    }
    
    function getCommandName()
    {
        return $this->argv->getFirstArgument();
    }
}