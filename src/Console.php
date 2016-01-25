<?php
namespace Slince\Console;

use Slince\Console\Commend\CommendInterface;
use Slince\Console\Context\Argv;

class Console
{

    protected $commends = [];

    /**
     * stdio
     *
     * @var Stdio
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

    function __construct(Io $io = null, HelperRegistery $helperRegistry = null)
    {
        if (is_null($io)) {
            $io = new Stdio(new Input(), new Output(), new Output('php://stderr'));
        }
        if (is_null($helperRegistry)) {
            $helperRegistry = new HelperRegistery();
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
        $name = $this->argv->getFirstArgument();
        if (isset($this->commends[$name])) {
            $this->runCommand($this->commends[$name]);
        }
    }

    function runCommand(CommandInterface $command)
    {
        $this->argv->bind($command->getDefinition());
        return $command->execute($this->io, $this->argv);
    }
}