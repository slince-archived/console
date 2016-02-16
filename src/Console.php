<?php
namespace Slince\Console;

use Slince\Console\Commend\CommendInterface;
use Slince\Console\Context\Io;
use Slince\Console\Context\Argv;
use Slince\Console\Context\Input;
use Slince\Console\Context\Output;
use Slince\Console\Context\Definition;
use Slince\Console\Context\Option;
use Slince\Console\Exception\CommandNotFoundException;

class Console
{

    protected $commands = [];

    /**
     * stdio
     *
     * @var Io
     */
    protected $io;

    /**
     * argv
     *
     * @var Argv
     */
    protected $argv;
    
    /**
     * helper registery
     *
     * @var HelperRegistery
     */
    protected $helperRegistry;

    function __construct(Io $io = null, HelperRegistry $helperRegistry = null)
    {
        if (is_null($io)) {
            $io = new Io(new Input(), new Output(), new Output('php://stderr'));
        }
        if (is_null($helperRegistry)) {
            $helperRegistry = new HelperRegistry($this);
        }
        $this->helperRegistry = $helperRegistry;
        $this->io = $io;
    }

    function getHelperRegistry()
    {
        return $this->helperRegistry;
    }
    
    function addCommand(CommandInterface $command)
    {
        $command->setConsole($this);
        $this->commands[$command->getName()] = $command;
    }
    
    function addCommands(array $commands)
    {
        foreach ($commands as $command) {
            $this->addCommand($command);
        }
    }

    function run(Argv $argv = null)
    {
        if (is_null($argv)) {
            $argv = new Argv($_SERVER['argv']);
        }
        $this->argv = $argv;
        try {
            $this->addCommands($this->getDefaultCommands());
            $commandName = $this->getCommandName();
            if ($this->argv->hasOptionParameter(['-h', '--help'])) {
                if (is_null($commandName)) {
                    $commandName = HelpCommand::COMMAND_NAME;
                }
                $this->argv->addArgument('command_name', $commandName);
                $commandName = HelpCommand::COMMAND_NAME;
            }
            $command = $this->find($commandName);
            $exitCode = $this->runCommand($command);
        } catch (\Exception $e) {
            $this->renderException($e);
            $exitCode = $e->getCode();
        }
        $exitCode = intval($exitCode);
        if ($exitCode > 255) {
            $exitCode = 255;
        }
        exit($exitCode);
    }

    function runCommand(CommandInterface $command)
    {
        $this->argv->bind($command->getDefinition()->merge($this->getDefaultDefinition()));
        return $command->execute($this->io, $this->argv);
    }
    
    function getCommandName()
    {
        return $this->argv->getFirstArgument();
    }
    
    function find($commandName)
    {
        if (isset($this->commands[$commandName])) {
            return $this->commands[$commandName];
        }
        $regex = '#^' .  preg_quote($commandName) . '#';
        $allCommandNames = array_keys($this->commands);
        $commandNames = preg_grep($regex, $allCommandNames);
        //完全不匹配的查找相似的命令
        if (empty($commandNames)) {
            $message = sprintf('Command "%s" is not defined.', $commandName);
            $alternatives = $this->getAlternatives($commandName, $commandNames);
            if (! empty($alternatives)) {
                if (1 == count($alternatives)) {
                    $message .= "\n\nDid you mean this?\n    ";
                } else {
                    $message .= "\n\nDid you mean one of these?\n    ";
                }
                $message .= implode("\n    ", $alternatives);
            }
        } else {
            //命令不全
            $message = sprintf('Command "%s" is ambiguous (%s).', $commandName, implode(',', $commandNames));
        }
        throw new CommandNotFoundException($message);
    }
    
    function getAlternatives($commandName, $commandNames)
    {
        $alternatives = array_filter($commandNames, function($name) use ($commandName) {
            if (levenshtein($commandName, $name) < strlen($commandName) / 3) {
                return true;
            }
            return false;
        });
        return $alternatives;
    }
    
    protected function getDefaultDefinition()
    {
        return new Definition([
            new Option('h', Option::VALUE_NONE, 'Display this help message'),
            new Option('help', Option::VALUE_NONE, 'Display this help message')
        ]);
    }
    
    protected function getDefaultCommands()
    {
        return [
            new HelpCommand()
        ];
    }
    
    protected function renderException(\Exception $e)
    {
        $messages = [
            get_class($e),
            $e->getMessage()
        ];
        $this->io->writeln(PHP_EOL . implode(PHP_EOL, $messages));
    }
    
    function getIo()
    {
        return $this->io;
    }
    
    function isWin()
    {
        return preg_match('/win/i', PHP_OS);
    }
    
    function clear()
    {
        $this->isWin() ? shell_exec('cls') : shell_exec('clear');
    }
}