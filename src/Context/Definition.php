<?php
namespace Slince\Console\Context;

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
        return isset($this->options[$name]) ? $this->options[$name] : null; 
    }
}