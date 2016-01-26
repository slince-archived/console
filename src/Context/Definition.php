<?php
namespace Slince\Console\Context;

use Slince\Console\Exception\InvalidArgumentException;

class Definition
{

    protected $options = [];

    protected $arguments = [];

    function addOption(Option $option)
    {
        $this->options[] = $option;
    }

    function addArgument(Argument $argument)
    {
        $this->arguments[] = $argument;
    }
    
    /**
     * 通过索引获取argument
     * 
     * @param int $index
     * @return Argument
     */
    function getArgumentByIndex($index)
    {
        $index= intval($index);
        $arguments = array_values($this->arguments);
        if (! isset($arguments[$index])) {
            throw new InvalidArgumentException(sprintf('The "%s" argument does not exist.', $index));
        }
        return $arguments[$index];
    }
    
    /**
     * 
     * @param string $name
     * 
     * @return Option
     */
    function getOption($name)
    {
        if (! isset($this->options[$name])) {
            throw new InvalidArgumentException(sprintf('The "%s" option does not exist.', $name));
        }
        return $this->options[$name]; 
    }
}