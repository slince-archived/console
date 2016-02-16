<?php
namespace Slince\Console;

class Help
{

    protected $usage;

    protected $argumentHelps = [];
    
    protected $optionHelps = [];
    
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

    function getUsage()
    {
        return $this->usage;
    }

    function setDescription($description)
    {
        $this->description = $description;
    }

    function getDescription()
    {
        return $this->description;
    }
    
    function setArgumentHelps($argumentHelps)
    {
        $this->argumentHelps = $argumentHelps;
    }
    
    function setOptionHelps($optionHelps)
    {
        $this->optionHelps = $optionHelps;
    }
    
    function getOptionHelps()
    {
        return $this->optionHelps;
    }
    
    function getArgumentsHelp()
    {
        return $this->buildArgumentsOrOptionsHelp($this->argumentHelps);
    }
    
    function getOptionsHelp()
    {
        return $this->buildArgumentsOrOptionsHelp($this->optionHelps);
    }
    
    function buildArgumentsOrOptionsHelp($parameters)
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