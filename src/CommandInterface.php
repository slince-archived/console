<?php
namespace Slince\Console;

interface CommandInterface
{

    function getName();

    function execute(Stdio $stdio);
}