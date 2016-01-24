<?php
namespace Slince\Console\Context;

class Input
{

    protected $stream;

    function __construct($handle = 'php://stdin', $mode = null)
    {
        if (is_null($mode)) {
            $model = 'r';
        }
        $this->stream = fopen($handle, $model);
    }

    function read()
    {
        return fgets($this->stream);
    }
}