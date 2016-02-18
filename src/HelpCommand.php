<?php
namespace Slince\Console;

use Slince\Console\Helper\HelperInterface;
use Slince\Console\Context\Io;
use Slince\Console\Context\Argv;
use Slince\Console\Context\Definition;
use Slince\Console\Context\Argument;
use Slince\Console\Context\Option;

class HelpCommand extends Command
{
    
    const COMMAND_NAME = 'help';

    protected $name = self::COMMAND_NAME;

    function configure()
    {
        $this->name = 'help';
        $this->addArgument('command_name', Option::VALUE_REQUIRED, 'The command name');
    }

    function execute(Io $io, Argv $argv)
    {
        $commandName = $argv->getArgument('command_name');
        $command = $this->console->find($commandName);
        $io->write($this->getCommandHelp($command));
    }

    function getCommandHelp(CommandInterface $command)
    {
        $help = $this->createHelp();
        $help->setDescription($command->getDescription());
        $optionHelps = $argumentHelps = [];
        foreach ($command->getDefinition()->getArguments() as $argument) {
            $argumentHelps[$argument->getName()] = $argument->getDescription();
        }
        foreach ($command->getDefinition()->getOptions() as $option) {
            $key = ($option->isShort() ? '-' : '--') . $option->getName();
            $optionHelps[$key] = $option->getDescription();
        }
        $help->setUsage($this->getCommandUsage($command));
        $help->setArgumentHelps($argumentHelps);
        $help->setOptionHelps($optionHelps);
        return $help;
    }

    protected function getCommandUsage(CommandInterface $command)
    {
        $argumentsUsages = [];
        foreach ($command->getDefinition()->getArguments() as $argument) {
            $usage = "<{$argument->getName()}>";
            if ($argument->isValueOptional()) {
                $usage = "[{$usage}]";
            }
            $argumentsUsages[] = $usage;
        }
        $usages[] = $command->getName();
        $options = $command->getDefinition()->getOptions();
        if ($haveOptions = ! empty($options)) {
            $usages[] = '[options]';
        }
        if (! empty($argumentsUsages)) {
            if ($haveOptions) {
                $usages[] = '--';
            }
            $usages[] = implode(' ', $argumentsUsages);
        }
        return implode(' ', $usages);;
    }
    
    protected function createHelp()
    {
        return new Help();
    }
}