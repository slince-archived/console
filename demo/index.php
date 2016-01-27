<?php
use Slince\Console\Command;
use Slince\Console\Console;
use Slince\Console\Context\Io;
use Slince\Console\Context\Argv;
use Slince\Console\Context\Option;
use Slince\Console\Question\Question;

include __DIR__ . '/../vendor/autoload.php';

class SayHalloCommand extends Command
{
    protected $name = 'hello';
    
    function configure()
    {
        $this->addArgument('name', Option::VALUE_REQUIRED);
        $this->addArgument('name', Option::VALUE_REQUIRED);
    }
    function execute(Io $io, Argv $argv)
    {
        $answer = $this->getHelper('Question')->ask(new Question('Whats\'s your name'));
        $this->io->out("Your name is {$answer}");
    }
}

$console = new Console();
$console->addCommand(new SayHalloCommand());
$console->run();

// $options = 'ab';
// var_dump(getopt($options));

// var_dump($argv);