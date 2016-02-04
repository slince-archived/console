<?php
namespace Slince\Console\Context;

use Slince\Console\Exception\RuntimeException;
use Slince\Console\Exception\InvalidArgumentException;

class Argv
{

    protected $tokens = [];

    protected $arguments = [];

    protected $options = [];

    protected $scriptName;

    /**
     * Definition
     *
     * @var Definition
     */
    protected $definition;

    function __construct($argv, Definition $definition = null)
    {
        // 排除脚本名称
        $this->scriptName = array_shift($argv);
        $this->tokens = $argv;
        if (! is_null($definition)) {
            $this->bind($definition);
        }
    }

    function addTokens($tokens)
    {
        $this->tokens += $tokens;
    }

    function getScriptName()
    {
        return $this->scriptName;
    }

    function bind(Definition $definition)
    {
        $this->definition = $definition;
        $this->parse();
    }

    protected function parse()
    {
        while (($token = array_shift($this->tokens)) != null) {
            if (substr($token, 0, 2) == '--') {
                $this->parseLongOption($token);
            } elseif (substr($token, 0, 1) == '-') {
                $this->parseShortOption($token);
            } else {
                $this->parseArgument($token);
            }
        }
    }

    protected function parseLongOption($token)
    {
        $name = substr($token, 2);
        $value = null;
        if (strpos($name, '=') !== false) {
            list ($name, $value) = explode('=', $name);
        }
        $this->addNewOption($name, $value);
    }

    protected function parseShortOption($token)
    {
        $name = $token = substr($token, 1);
        $value = null;
        // -abc情况判断
        if (strlen($token) > 1) {
            $name = $token{0};
            $option = $this->definition->getOption($name);
            // 如果必须有值，则第一个是option name，其它是option value
            if ($option->isValueRequired()) {
                $value = substr($token, 1);
            } else { // 否则作为 -a -b -c的简写形式
                for ($i = 1; $i <= strlen($token); $i ++) {
                    array_unshift($this->tokens, "-{$token{$i}}");
                }
            }
        }
        $this->addNewOption($name, $value);
    }

    protected function parseArgument($token)
    {
        $index = count($this->arguments);
        try {
            $argument = $this->definition->getArgumentByIndex($index);
            $this->arguments[$argument->getName()] = $token;
        } catch (InvalidArgumentException $e) {}
    }

    protected function addNewOption($name, $value)
    {
        $option = $this->definition->getOption($name);
        if (is_null($value)) {
            if ($option->isValueRequired()) {
                $value = $this->getNextToken();
                if (! empty($value)) {
                    array_shift($this->tokens);
                } else {
                    throw new RuntimeException(sprintf('The "%s" option requires a value.', $option->isShort() ? "-{$name}" : "--{$name}"));
                }
            } elseif ($option->isValueOptional()) {
                $value = $option->getDefault();
            }
        } else {
            if ($option->isValueNone()) {
                throw new RuntimeException(sprintf('The "%s" option does not accept a value.', $option->isShort() ? "-{$name}" : "--{$name}"));
            }
        }
        $this->options[$name] = $value;
    }

    function getFirstArgument()
    {
        foreach ($this->tokens as $token) {
            if ($token && $token{0} != '-') {
                return $token;
            }
        }
    }

    function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    function addArguments(array $arguments)
    {
        $this->arguments = array_merge($this->arguments, $arguments);
    }

    function addArgument($name, $argument)
    {
        $this->arguments[$name] = $argument;
    }

    function getArguments()
    {
        return $this->arguments;
    }

    function getArgument($name)
    {
        return isset($this->arguments[$name]) ? $this->arguments[$name] : null;
    }

    function setOptions(array $options)
    {
        $this->options = $options;
    }

    function addOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);
    }

    function addOption($name, $option)
    {
        $this->options[$name] = $option;
    }

    function getOptions()
    {
        return $this->options;
    }

    function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }

    function hasOptionParameter($parameters)
    {
        $parameters = (array) $parameters;
        return ! empty(array_intersect($this->tokens, $parameters));
    }

    protected function getNextToken()
    {
        return reset($this->tokens);
    }
}