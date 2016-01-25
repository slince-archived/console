<?php
namespace Slince\Console;

use Slince\Console\Context\Input;
use Slince\Console\Context\Output;

class Io
{

    protected $in;

    protected $out;

    protected $err;

    function __construct(Input $in, Output $out, Output $err)
    {
        $this->in = $in;
        $this->out = $out;
        $this->err = $err;
    }

    public function in()
    {
        return rtrim($this->in->read(), PHP_EOL);
    }

    function out($message)
    {
        $this->out->write($message);
    }

    function outln($message)
    {
        $this->out->write($message, true);
    }
}