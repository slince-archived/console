<?php
namespace Slince\Console;

class Command implements CommandInterface
{

    protected $name;

    function getName()
    {
        return $this->name;
    }
}