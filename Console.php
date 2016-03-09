<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */
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

    /**
     * 注册的command实例
     * 
     * @var array
     */
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

    /**
     * 获取helper注册器
     * 
     * @return \Slince\Console\HelperRegistery
     */
    function getHelperRegistry()
    {
        return $this->helperRegistry;
    }
    
    /**
     * 添加一个command
     * 
     * @param CommandInterface $command
     */
    function addCommand(CommandInterface $command)
    {
        $command->setConsole($this);
        $this->commands[$command->getName()] = $command;
    }
    
    /**
     * 添加一组command
     * 
     * @param array $commands
     */
    function addCommands(array $commands)
    {
        foreach ($commands as $command) {
            $this->addCommand($command);
        }
    }

    /**
     * 运行控制台应用
     * 
     * @param Argv $argv
     */
    function run(Argv $argv = null)
    {
        if (is_null($argv)) {
            $argv = new Argv($_SERVER['argv']);
        }
        $this->argv = $argv;
        try {
            $this->addCommands($this->getDefaultCommands());
            $commandName = $this->getCommandName();
            if (empty($commandName) || $this->argv->hasOptionParameter(['-h', '--help'])) {
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

    /**
     * 执行command
     * @param CommandInterface $command
     */
    function runCommand(CommandInterface $command)
    {
        $this->argv->bind($command->getDefinition()->merge($this->getDefaultDefinition()));
        return $command->execute($this->io, $this->argv);
    }
    
    /**
     * 获取要执行的command名称
     * @return string
     */
    function getCommandName()
    {
        return $this->argv->getFirstArgument();
    }
    
    /**
     * 寻找command实例对象
     * 
     * @param string $commandName
     * @throws CommandNotFoundException
     * @return multitype:
     */
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
    
    /**
     * 如果command不存在，则寻找近似command
     * @param string $commandName
     * @param array $commandNames
     * @return array
     */
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
    
    /**
     * 获取默认definition
     * 
     * @return \Slince\Console\Context\Definition
     */
    protected function getDefaultDefinition()
    {
        return new Definition([
            new Option('h', Option::VALUE_NONE, 'Display this help message'),
            new Option('help', Option::VALUE_NONE, 'Display this help message')
        ]);
    }
    
    /**
     * 获取默认命令对象实例
     * 
     * @return multitype:\Slince\Console\HelpCommand
     */
    protected function getDefaultCommands()
    {
        return [
            new HelpCommand()
        ];
    }
    
    /**
     * 渲染异常
     * 
     * @param \Exception $e
     */
    protected function renderException(\Exception $e)
    {
        $messages = [
            get_class($e),
            '<error>' . $e->getMessage() . '</error>'
        ];
        $this->io->writeln(PHP_EOL . implode(PHP_EOL, $messages));
    }
    
    /**
     * 获取输入输出流对象
     * 
     * @return \Slince\Console\Context\Io
     */
    function getIo()
    {
        return $this->io;
    }
    
    /**
     * 是否是windows平台
     * 
     * @return number
     */
    function isWin()
    {
        return (boolean)preg_match('/win/i', PHP_OS);
    }
}