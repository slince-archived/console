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
        
        $answer = $this->getHelper('Question')
            ->ask(new Question('asda<success>Whats hello<error>your<success> name:</success>adada</error>sasadsa</success>ha'));
        $io->write("Your name is {$answer}");
        return 0;
        /*
        if($this->getHelper('Question')->ask(new ConfirmQuestion('Are you a boy?', true))){
            $io->out("Your choose true");
        } else {
            $io->out("Your choose false");
        }
        */
        $question = new ChoiceQuestion('Whats your favorite sports', ['sddddd' => 'baskerball', 'foot ball', 'ping pang'], 'sddddd');
        $question->setMaxAttempts(3);
        $question->setMultiSelect(true);
        $answer = $this->getHelper('Question')->ask($question);
        print_r($answer);exit;
        $io->write("You like {$answer}");
    }
}

$console = new Console();
$console->addCommand(new SayHalloCommand());
$console->run();

// $options = 'ab';
// var_dump(getopt($options));

// var_dump($argv);