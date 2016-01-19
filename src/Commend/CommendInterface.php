<?php
namespace Slince\Console\Commend;

use Slince\Console\Stdio;

interface CommendInterface
{

    function getName();

    function execute(Stdio $stdio);
}