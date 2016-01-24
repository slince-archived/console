<?php
namespace Slince\Console;

use Slince\Console\Helper\HelperInterface;

class HelperRegistery
{

    protected $loaded = [];

    function load($name)
    {
        $className = $this->resolveClassName($name);
        $instance = $this->create($className);
        $this->loaded[$name] = $instance;
    }

    function get($name)
    {
        if (! isset($this->loaded[$name])) {
            $this->load($name);
        }
        return $this->loaded[$name];
    }

    protected function resolveClassName($class)
    {
        return "\\Slince\\Console\\Helper\\{$class}Helper";
    }

    protected function create($className)
    {
        return new $className();
    }

    function register($name, HelperInterface $helper)
    {
        $this->loaded[$name] = $helper;
    }
}