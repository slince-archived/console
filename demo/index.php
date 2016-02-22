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
        $this->setDescription('Say hello to someone');
        $this->addArgument('name2', Option::VALUE_REQUIRED);
        $this->addArgument('age', Option::VALUE_OPTIONAL);
        $this->addOption('yell', Option::VALUE_REQUIRED, 'if set will output uppercase');
    }
    function execute(Io $io, Argv $argv)
    {
        
        $question = new ChoiceQuestion('Whats your favorite sports', ['baskerball', 'foot ball', 'ping pang'], 0);
        $question->setMaxAttempts(3);
        $question->setMultiSelect(true);
        $answer = $this->getHelper('Question')->ask($question);
        $io->write(sprintf("You like %s", implode(', ', $answer)));
    }
}

$console = new Console();
$console->addCommand(new SayHalloCommand());
$console->run();