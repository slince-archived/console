<?php
namespace Slince\Console\Context;

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

    public function read()
    {
        return rtrim($this->in->read(), PHP_EOL);
    }

    function write($message)
    {
        $this->out->write($message);
    }

    function writeln($message)
    {
        $this->out->write($message, true);
    }
}