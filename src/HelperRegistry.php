<?php
namespace Slince\Console;

use Slince\Console\Helper\HelperInterface;

class HelperRegistry
{

    protected $loaded = [];
    
    /**
     * Console
     * 
     * @var Console
     */
    protected $console;
    
    function __construct(Console $console)
    {
        $this->console = $console;
    }

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
        return new $className($this->console->getIo());
    }

    function register($name, HelperInterface $helper)
    {
        $this->loaded[$name] = $helper;
    }
}