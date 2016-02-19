<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Console\Context;

class Io
{

    /**
     * 输入对象
     * 
     * @var Input
     */
    protected $in;

    /**
     * 输出对象
     * 
     * @var Output
     */
    protected $out;

    /**
     * 错误输出
     * 
     * @var Output
     */
    protected $err;

    function __construct(Input $in, Output $out, Output $err)
    {
        $this->in = $in;
        $this->out = $out;
        $this->err = $err;
    }

    /**
     * 读消息
     * 
     * @return string
     */
    public function read()
    {
        return rtrim($this->in->read(), PHP_EOL);
    }

    /**
     * 写消息
     * 
     * @param string $message
     */
    function write($message)
    {
        $this->out->write($message);
    }

    /**
     * 换行输入
     * 
     * @param string $message
     */
    function writeln($message)
    {
        $this->out->write($message, true);
    }
}