<?php
include __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Console\Application;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\Table;

class GreetCommand extends Command
{
    protected function configure()
    {
        $this
        ->setName('hello')
        ->setDescription('Greet someone')
//         ->addArgument(
//             'name',
//             InputArgument::REQUIRED,
//             'Who do you want to greet?'
//         )
//         ->addArgument(
//             'age',
//             InputArgument::OPTIONAL,
//             'Who do you want to greet?'
//         )
        ->addOption(
            'yell',
            null,
            InputOption::VALUE_REQUIRED,
            'If set, the task will yell in uppercase letters'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
//         $name = $input->getArgument('name');
//         if ($name) {
//             $text = 'Hello '.$name;
//         } else {
//             $text = 'Hello';
//         }
//         if ($input->getOption('yell')) {
//             $text = strtoupper($text);
//         }
//         $output->writeln($text);
        $helper = $this->getHelper('question');
        $question = new Question('<error>Please enter <info>the name of the bundle</error></info>');
        $bundle = $helper->ask($input, $output, $question);

//         $question = new ChoiceQuestion(
//             'Please select your favorite color (defaults to red)',
//             array('asssssssssss' => 'red', 'blue', 'yellow'),
//             0
//         );
//         $question->setErrorMessage('Color %s is invalid.');
        
//         $color = $helper->ask($input, $output, $question);
//         $output->writeln('You have just selected: '.$color);
//         $question = new ChoiceQuestion(
//             'Please select your favorite colors (defaults to red and blue)',
//             array('red', 'blue', 'yellow')
//         );
//         $question->setMultiselect(true);
        
//         $colors = $helper->ask($input, $output, $question);
//         $output->writeln('You have just selected: ' . implode(', ', $colors));

//         $bundles = array('AcmeDemoBundle', 'AcmeBlogBundle', 'AcmeStoreBundle');
//         $question = new Question('Please enter the name of a bundle', 'FooBundle');
//         $question->setAutocompleterValues($bundles);
        
//         $name = $helper->ask($input, $output, $question);
//         $question = new Question('What is the database password?');
//         $question->setHidden(true);
//         $question->setHiddenFallback(false);
        
//         $password = $helper->ask($input, $output, $question);
//         $output->writeln($password);


        // create a new progress bar (50 units)
//         $progress = new ProgressBar($output, 50);
//         // start and displays the progress bar
//         $progress->start();
        
//         $i = 0;
//         while ($i++ < 50) {
//             // ... do some work
//             // advance the progress bar 1 unit
//             $progress->advance();
// //             sleep(1);
//             // you can also advance the progress bar by more than 1 unit
//             // $progress->advance(3);
//         }
//         // ensure that the progress bar is at 100%
//         $progress->finish();

        $table = new Table($output);
        $table
        ->setHeaders(array('ISBN', 'Title', 'Author'))
        ->setRows(array(
            array('99921-58-10-7', 'Divine Comedy', 'Dante Alighieri'),
            array('9971-5-0210-0', 'A Tale of Two Cities          ', 'Charles Dickens'),
            array('960-425-059-0', 'The Lord of the Rings', 'J. R. R. Tolkien'),
            array('80-902734-1-6', 'And Then There Were None', 'Agatha Christie'),
        ));
        $table->setStyle('compact');
        $table->render();
    }
}

$application = new Application();
$application->add(new GreetCommand());
$application->run();