<?php
use Slince\Console\Command;
use Slince\Console\Console;
use Slince\Console\Context\Io;
use Slince\Console\Context\Argv;
use Slince\Console\Context\Option;
use Slince\Console\Question\Question;
use Slince\Console\Question\ConfirmQuestion;
use Slince\Console\Question\ChoiceQuestion;

include __DIR__ . '/../vendor/autoload.php';

class SayHalloCommand extends Command
{
    protected $name = 'hello';
    
    function configure()
    {
        $this->addArgument('name', Option::VALUE_REQUIRED);
    }
    function execute(Io $io, Argv $argv)
    {
        /*
         $answer = $this->getHelper('Question')->ask(new Question('Whats\'s your name: '));
         $io->out("Your name is {$answer}");
         */
        /*
        if($this->getHelper('Question')->ask(new ConfirmQuestion('Are you a boy?', true))){
            $io->out("Your choose true");
        } else {
            $io->out("Your choose false");
        }
        */
        $answer = $this->getHelper('Question')->ask(new ChoiceQuestion('What\'s your favorite sports', ['baskerball', 'foot ball', 'ping pang']));
        $io->out("You like {$answer}");
    }
}

$console = new Console();
$console->addCommand(new SayHalloCommand());
$console->run();