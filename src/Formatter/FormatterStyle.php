<?php
namespace Slince\Console\Formatter;

use Slince\Console\Exception\InvalidArgumentException;
use Slince\Console\Formatter\Label\Label;

abstract class FormatterStyle
{

    protected static $registerLabels = [
        'success' => '\\Slince\\Console\\Formatter\\Label\\Success',
        'error' => '\\Slince\\Console\\Formatter\\Label\\Error',
        'warning' => '\\Slince\\Console\\Formatter\\Label\\Warning',
        'info' => '\\Slince\\Console\\Formatter\\Label\\Info'
    ];

    protected $labels;

    function __construct()
    {
        $this->configureLabelStyle();
    }

    protected static function registerLabel($name, $className)
    {
        self::$registerLabels[$name] = $className;
    }

    function getLabel($name)
    {
        if (isset($this->labels[$name])) {
            return $this->labels[$name];
        }
        if (! isset($this->registerLabels[$name])) {
            throw new InvalidArgumentException(
                sprintf('Invalid label specified: "%s". Expected one of (%s)', $name, 
                    implode(', ', array_keys($this->registerLabels))
            ));
        }
        return $this->labels[$name] = new $this->registerLabels[$name]();
    }

    function createLabel($name)
    {
        return $this->labels[$name] = new Label();
    }
    
    abstract function configureLabelStyle();
}