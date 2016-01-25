<?php
namespace Slince\Console;

interface CommandInterface
{

    function getName();
    
    function getDefinition();
    
    function setConsole(Console $console);

    function execute(Stdio $io, Argv $argv);
}