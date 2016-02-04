<?php
namespace Slince\Console\Context;

use Slince\Console\Exception\InvalidArgumentException;

class Definition
{

    protected $options = [];

    protected $arguments = [];

    function __construct(array $definition = [])
    {
        $this->setDefinition($definition);
    }

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

    function addOption(Option $option)
    {
        $this->options[$option->getName()] = $option;
    }

    function setOptions(array $options)
    {
        $this->options = $options;
    }

    function addArgument(Argument $argument)
    {
        $this->arguments[$argument->getName()] = $argument;
    }

    function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    function getArguments()
    {
        return $this->arguments;
    }

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

    function getOptions()
    {
        return $this->options;
    }

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