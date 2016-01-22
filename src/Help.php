<?php
namespace Slince\Console;

class Help
{

    protected $description;

    protected $summary;

    protected $usage;

    protected $default;

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
    
    function render()
    {
    }
}