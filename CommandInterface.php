<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Console;

use Slince\Console\Context\Io;
use Slince\Console\Context\Argv;
use Slince\Console\Context\Definition;

interface CommandInterface
{

    /**
     * 获取command name
     *
     * @return string
     */
    function getName();

    /**
     * 获取command的definition
     * 
     * @return Definition
     */
    function getDefinition();

    /**
     * 设置主控制台应用对象
     *
     * @param Console $console
     */
    function setConsole(Console $console);

    /**
     * 配置command的参数和option信息
     */
    function configure();

    /**
     * 运行的预先回调
     * 
     * @param Io $io
     * @param Argv $argv
     */
    function initialize(Io $io, Argv $argv);

    /**
     * 执行该command
     * 
     * @param Io $io
     * @param Argv $argv
     */
    function execute(Io $io, Argv $argv);
}