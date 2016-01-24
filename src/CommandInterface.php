<?php
namespace Slince\Console;

interface CommandInterface
{

    function getName();
    
    function getOptions();
    
    function getArguments();

    function execute(Stdio $io, Argv $argv);
}