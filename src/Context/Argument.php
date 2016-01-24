<?php
namespace Slince\Console\Context;

class Argument
{

    const VALUE_NONE = 1;

    const VALUE_REQUIRED = 2;

    const VALUE_OPTIONAL = 4;

    protected $name;

    protected $valueMode;

    protected $description;

    protected $default;

    function __construct($name, $valueMode, $description = null, $default = null)
    {
        $this->name = $name;
        $this->valueMode = $valueMode;
        $this->description = $description;
        $this->default = $default;
    }

    function getName()
    {
        return $this->name;
    }

    function isValueRequired()
    {
        return $this->valueMode === self::VALUE_REQUIRED;
    }

    function isValueOptional()
    {
        return $this->valueMode === self::VALUE_OPTIONAL;
    }

    function getDescription()
    {
        return $this->description;
    }

    function getDefault()
    {
        return $this->default;
    }
}