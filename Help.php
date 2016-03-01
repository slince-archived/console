<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Console;

class Help
{

    /**
     * usage
     * 
     * @var string
     */
    protected $usage;

    /**
     * 所有的argument帮助信息
     * 
     * @var array
     */
    protected $argumentHelps = [];
    
    /**
     * 所有的option帮助信息
     * 
     * @var array
     */
    protected $optionHelps = [];
    
    /**
     * description
     * 
     * @var string
     */
    protected $description;
    
    function __toString()
    {
        return $this->render();
    }
    
    /**
     *
     * Sets the single-line summary.
     *
     * @param string $summary The single-line summary.
     *
     * @return null
     *
     */
    function setSummary($summary)
    {
        $this->summary = $summary;
    }

    /**
     *
     * Gets the single-line summary.
     *
     * @return string
     *
     */
    function getSummary()
    {
        return $this->summary;
    }

    /**
     *
     * Sets the custom usage line(s).
     *
     * @param string|array $usage The usage line(s).
     *
     * @return null
     *
     */
    function setUsage($usage)
    {
        $this->usage = $usage;
    }

    /**
     * 获取usage
     * @return string
     */
    function getUsage()
    {
        return $this->usage;
    }

    /**
     * 设置描述信息
     * 
     * @param string $description
     */
    function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * 获取描述信息
     * 
     * @return string
     */
    function getDescription()
    {
        return $this->description;
    }
    
    /**
     * 设置argument帮助信息
     * 
     * @param array $argumentHelps
     */
    function setArgumentHelps($argumentHelps)
    {
        $this->argumentHelps = $argumentHelps;
    }
    
    /**
     * 设置option帮助信息
     *
     * @param array $optionHelps
     */
    function setOptionHelps($optionHelps)
    {
        $this->optionHelps = $optionHelps;
    }
    
    /**
     * 获取option帮助信息
     * 
     * @return array
     */
    function getOptionHelps()
    {
        return $this->optionHelps;
    }
    
    /**
     * 获取arguments帮助
     * 
     * @return string
     */
    function getArgumentsHelp()
    {
        return $this->buildArgumentsOrOptionsHelp($this->argumentHelps);
    }
    
    /**
     * 获取options帮助
     *
     * @return string
     */
    function getOptionsHelp()
    {
        return $this->buildArgumentsOrOptionsHelp($this->optionHelps);
    }
    
    /**
     * 构建argument和option的帮助信息
     * 
     * @param array $parameters
     * @return string
     */
    protected function buildArgumentsOrOptionsHelp($parameters)
    {
        if (empty($parameters)) {
            return '';
        }
        $keyMaxWidth = max(array_map('strlen', array_keys($parameters)));
        $helps = [];
        foreach ($parameters as $key => $parameter) {
            $helps[] = sprintf("  %-{$keyMaxWidth}s    %s", $key, $parameter);
        }
        return implode(PHP_EOL, $helps);
    }
    
    /**
     * 渲染当前help
     * 
     * @return string
     */
    function render()
    {
        $argumentsHelp = $this->getArgumentsHelp() ?: 'None';
        $optionsHelp = $this->getOptionsHelp() ?: 'None';
        return <<<EOT
Usage:
  {$this->usage}

Arguments:
{$argumentsHelp}

Options:
{$optionsHelp}

Description:
  {$this->description}

EOT;
    }
}