<?php
namespace Slince\Console;

use Slince\Console\Context\Io;
use Slince\Console\Context\Argv;

interface CommandInterface
{

    function getName();

    function getDefinition();

    function setConsole(Console $console);

    function execute(Io $io, Argv $argv);
}