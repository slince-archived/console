<?php
use Slince\Console\Command;
use Slince\Console\Console;
use Slince\Console\Context\Io;
use Slince\Console\Context\Argv;

include __DIR__ . '/../vendor/autoload.php';

class SayHalloCommand extends Command
{
    protected $name = 'hello';
    
    function init()
    {
        
    }
    
    function execute(Io $io, Argv $argv)
    {
        $io->out("Say your name: ");
        $name = $io->in();
        $io->outln("Hello {$name}");
    }
}

$console = new Console();
$console->addCommand(new SayHalloCommand());
$console->run();

// $options = 'ab';
// var_dump(getopt($options));

// var_dump($argv);