<?php
namespace Slince\Console;

use Slince\Console\Commend\CommendInterface;

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

    function __construct(Stdio $io = null)
    {
        if (is_null($io)) {
            $io = new Stdio(new Input(), new Output(), new Output('php://stderr'));
        }
        $this->io = $io;
    }

    function addCommand(CommandInterface $command)
    {
        $this->commends[$command->getName()] = $command;
    }

    function run(Argv $argv = null)
    {
        if (is_null($argv)) {
            $argv = new Argv($_SERVER['argv']);
        }
        $this->argv = $argv;
        $commandName = $this->argv->shift();
        if (isset($this->commends[$commandName])) {
            $this->runCommand($this->commends[$commandName]);
        }
    }

    function runCommand(CommandInterface $command)
    {
        return $command->execute($this->io, $this->argv);
    }
}