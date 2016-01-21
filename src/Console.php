<?php
namespace Slince\Console;

use Slince\Console\Commend\CommendInterface;

class Console
{

    protected $commends = [];

    /**
     * argv
     *
     * @var Argv
     */
    protected $argv;

    function addCommand(CommandInterface $command)
    {
        $this->commends[$command->getName()] = $command;
    }

    function run(Argv $argv = null)
    {
        if (is_null($argv)) {
            $argv = new Argv($_SERVER['argv']);
        }
        $this->argv = $agrv;
        $commandName = $this->argv->shift();
        if (isset($this->commends[$commandName])) {
            $this->runCommand($this->commends[$commandName]);
        }
    }

    function runCommand(CommandInterface $command)
    {
        return $command->execute();
    }
}