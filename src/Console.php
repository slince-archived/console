<?php
namespace Slince\Console;

use Slince\Console\Commend\CommendInterface;

class Console
{

    protected $commends = [];

    function addCommand(CommendInterface $commend)
    {
        $this->commends[$commend->getName()] = $commend;
    }
}