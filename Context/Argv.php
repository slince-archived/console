<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Console\Context;

use Slince\Console\Exception\RuntimeException;
use Slince\Console\Exception\InvalidArgumentException;

class Argv
{

    /**
     * token
     * 
     * @var array
     */
    protected $tokens = [];

    /**
     * 解析结果，arguments
     * 
     * @var array
     */
    protected $arguments = [];

    /**
     * 解析结果，options
     * 
     * @var array
     */
    protected $options = [];

    /**
     * 脚本名称
     * 
     * @var string
     */
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

    /**
     * 添加tokens
     * 
     * @param array $tokens
     */
    function addTokens($tokens)
    {
        $this->tokens += $tokens;
    }

    /**
     * 获取脚本名称
     * 
     * @return string
     */
    function getScriptName()
    {
        return $this->scriptName;
    }

    /**
     * 绑定definition
     * 
     * @param Definition $definition
     */
    function bind(Definition $definition)
    {
        $this->definition = $definition;
        $this->parse();
    }

    /**
     * 开始解析token
     */
    protected function parse()
    {
        $this->shiftFirstArgument();
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

    /**
     * 解析长option
     * 
     * @param string $token
     */
    protected function parseLongOption($token)
    {
        $name = substr($token, 2);
        $value = null;
        if (strpos($name, '=') !== false) {
            list ($name, $value) = explode('=', $name);
        }
        $this->addNewOption($name, $value);
    }

    /**
     * 解析短option
     * 
     * @param string $token
     */
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

    /**
     * 解析argument
     * 
     * @param string $token
     */
    protected function parseArgument($token)
    {
        $index = count($this->arguments);
        try {
            $argument = $this->definition->getArgumentByIndex($index);
            $this->arguments[$argument->getName()] = $token;
        } catch (InvalidArgumentException $e) {}
    }
    
    /**
     * 第一个argument作为命令名称，解析前需要先删除
     * @return void
     */
    protected function shiftFirstArgument()
    {
        foreach ($this->tokens as $key => $token) {
            if ($token && $token{0} != '-') {
                unset($this->tokens[$key]);
                break;
            }
        }
    }

    /**
     * 添加一个option
     * 
     * @param string $name
     * @param string $value
     * @throws RuntimeException
     */
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
            } elseif($option->isValueNone()) {
                $value = true;
            } 
        } else {
            if ($option->isValueNone()) {
                throw new RuntimeException(sprintf('The "%s" option does not accept a value.', $option->isShort() ? "-{$name}" : "--{$name}"));
            }
        }
        $this->options[$name] = $value;
    }

    /**
     * 获取第一个argument
     * 
     * @return string
     */
    function getFirstArgument()
    {
        foreach ($this->tokens as $token) {
            if ($token && $token{0} != '-') {
                return $token;
            }
        }
    }

    /**
     * 批量设置arguments
     * 
     * @param array $arguments
     */
    function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    /**
     * 添加一个argument
     * @param array $arguments
     */
    function addArguments(array $arguments)
    {
        $this->arguments = array_merge($this->arguments, $arguments);
    }

    /**
     * 添加一个argument
     * @param array $arguments
     */
    function addArgument($name, $argument)
    {
        $this->arguments[$name] = $argument;
    }

    /**
     * 获取所有的arguments
     * @return array
     */
    function getArguments()
    {
        return $this->arguments;
    }

    /**
     * 获取单个argument
     * 
     * @param string $name
     * @return string|number
     */
    function getArgument($name)
    {
        return isset($this->arguments[$name]) ? $this->arguments[$name] : null;
    }

    /**
     * 批量设置options
     * 
     * @param array $options
     */
    function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * 批量添加options
     * 
     * @param array $options
     */
    function addOptions(array $options)
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * 添加单个option
     * 
     * @param string $name
     * @param string|number $option
     */
    function addOption($name, $option)
    {
        $this->options[$name] = $option;
    }

    /**
     * 获取所有的options
     * 
     * @return array
     */
    function getOptions()
    {
        return $this->options;
    }

    /**
     * 获取单个option
     * 
     * @param string|number $name
     */
    function getOption($name)
    {
        return isset($this->options[$name]) ? $this->options[$name] : null;
    }

    /**
     * 参数是否存在
     * 
     * @param array|mixed $parameters
     * @return boolean
     */
    function hasOptionParameter($parameters)
    {
        $parameters = (array) $parameters;
        $results = array_intersect($this->tokens, $parameters);
        return ! empty($results);
    }

    /**
     * 获取下一个token
     */
    protected function getNextToken()
    {
        return reset($this->tokens);
    }
}