<?php
namespace Slince\Console\Context;

class Argv
{

    protected $tokens = [];

    protected $arguments = [];

    protected $options = [];

    protected $scriptName;

    function __construct($argv)
    {
        // 排出脚本名称
        $this->scriptName = array_shift($argv);
        $this->tokens = $argv;
        $this->parse();
    }

    function getScriptName()
    {
        return $this->scriptName;
    }

    protected function parse()
    {
        foreach ($this->tokens as $token) {
            if (substr($token, 0, 2) == '--') {
                $this->parseLongOption($token);
            } elseif(substr($token, 0, 1) == '-') {
                $this->parseShortOption($token);
            } else {
                $this->parseArgument($token);
            }
        }
    }
    
    protected function parseLongOption()
    {
        
    }
    
    protected function parseShortOption()
    {
        
    }
    
    protected function parseArgument()
    {
        
    }
    
    function getFirstArgument()
    {
        foreach ($this->argv as $argument) {
            if ($argument && '-' === $argument[0]) {
                continue;
            }
            return $argument;
        }
    }

    function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
    }

    function getArguments()
    {
        return $this->arguments;
    }

    function setOptions(array $options)
    {
        $this->options = $options;
    }

    function getOptions()
    {
        return $this->options;
    }
}