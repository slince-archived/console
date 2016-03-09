<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Console\Context;

class Input
{

    /**
     * 输入流
     * 
     * @var resource
     */
    protected $stream;

    function __construct($handle = 'php://stdin', $mode = null)
    {
        if (is_null($mode)) {
            $model = 'r';
        }
        $this->stream = fopen($handle, $model);
    }

    /**
     * 读消息
     * 
     * @return string
     */
    function read()
    {
        return fgets($this->stream);
    }
}