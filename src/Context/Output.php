<?php
namespace Slince\Console\Context;

class Output
{

    protected $stream;

    function __construct($handle = 'php://stdout', $mode = null)
    {
        if (is_null($mode)) {
            $model = 'w';
        }
        $this->stream = fopen($handle, $model);
    }

    function write($message, $newLine = false)
    {
        if ($newLine) {
            $message .= PHP_EOL;
        }
        return fwrite($this->stream, $message);
    }
}