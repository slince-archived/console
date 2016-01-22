<?php
use Slince\Console\Stdio;
use Slince\Console\Command;
use Slince\Console\Console;
use Slince\Console\Argv;

// include __DIR__ . '/../vendor/autoload.php';

// class SayHalloCommand extends Command
// {
//     protected $name = 'hello';
    
//     function init()
//     {
        
//     }
    
//     function execute(Stdio $io, Argv $argv)
//     {
//         $io->out("Say your name: ");
//         $name = $io->in();
//         $io->outln("Hello {$name}");
//     }
// }

// $console = new Console();
// $console->addCommand(new SayHalloCommand());
// $console->run();


$model = 2 | 9;
var_dump($model & 9);