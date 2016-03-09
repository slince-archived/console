<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Console\Context;

use Slince\Console\Exception\InvalidArgumentException;

class Definition
{

    /**
     * options
     * 
     * @var array
     */
    protected $options = [];

    /**
     * arguments
     * 
     * @var array
     */
    protected $arguments = [];

    function __construct(array $definition = [])
    {
        $this->setDefinition($definition);
    }

    /**
     * 设置definition
     * 
     * @param array $definition
     */
    function setDefinition(array $definition)
    {
        $arguments = [];
        $options = [];
        foreach ($definition as $item) {
            if ($item instanceof Option) {
                $options[] = $item;
            } else {
                $arguments[] = $item;
            }
        }
        $this->setArguments($arguments);
        $this->setOptions($options);
    }

    /**
     * 添加一个option
     * 
     * @param Option $option
     */
    function addOption(Option $option)
    {
        $this->options[$option->getName()] = $option;
    }

    /**
     * 设置一组options
     * 
     * @param array $options
     */
    function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * 添加一个argument
     * 
     * @param Argument $argument
     */
    function addArgument(Argument $argument)
    {
        $this->arguments[$argument->getName()] = $argument;
    }

    /**
     * 设置一组arguments
     * 
     * @param array $arguments
     */
    function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * 获取arguments
     * 
     * @return array
     */
    function getArguments()
    {
        return $this->arguments;
    }

    /**
     * 获取argument
     * 
     * @throws InvalidArgumentException
     * @return Argument
     */
    function getArgument()
    {
        if (! isset($this->arguments[$name])) {
            throw new InvalidArgumentException(sprintf('The "%s" Argument does not exist.', $name));
        }
        return $this->arguments[$name];
    }

    /**
     * 通过索引获取argument
     *
     * @param int $index
     * @return Argument
     */
    function getArgumentByIndex($index)
    {
        $index = intval($index);
        $arguments = array_values($this->arguments);
        if (! isset($arguments[$index])) {
            throw new InvalidArgumentException(sprintf('The "%s" argument does not exist.', $index));
        }
        return $arguments[$index];
    }

    /**
     * 获取option
     * 
     * @param string $name
     * @return Option
     */
    function getOption($name)
    {
        if (! isset($this->options[$name])) {
            throw new InvalidArgumentException(sprintf('The "%s" option does not exist.', $name));
        }
        return $this->options[$name];
    }

    /**
     * 获取全部的options
     * 
     * @return array
     */
    function getOptions()
    {
        return $this->options;
    }

    /**
     * 合并另外一个Definition
     * 
     * @param Definition $definition
     * @return \Slince\Console\Context\Definition
     */
    function merge(Definition $definition)
    {
        foreach ($definition->getArguments() as $argument) {
            $this->addArgument($argument);
        }
        foreach ($definition->getOptions() as $option) {
            $this->addOption($option);
        }
        return $this;
    }
}