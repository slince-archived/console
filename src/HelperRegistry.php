<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Console;

use Slince\Console\Helper\HelperInterface;

class HelperRegistry
{

    /**
     * 已经加载的helper
     * 
     * @var array
     */
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

    /**
     * 加载helper，已存在的话会覆盖
     * 
     * @param string $name
     */
    function load($name)
    {
        $className = $this->resolveClassName($name);
        $instance = $this->create($className);
        return $this->loaded[$name] = $instance;
    }

    /**
     * 自动获取helper，不存在会尝试创建
     * 
     * @param string $name
     * @return HelperInterface
     */
    function get($name)
    {
        if (! isset($this->loaded[$name])) {
            $this->load($name);
        }
        return $this->loaded[$name];
    }

    /**
     * 处理helper的类名
     * @param string $class
     * @return string
     */
    protected function resolveClassName($class)
    {
        return "\\Slince\\Console\\Helper\\{$class}Helper";
    }

    /**
     * 创建helper对象
     * 
     * @param string $className
     * @return HelperInterface
     */
    protected function create($className)
    {
        return new $className($this->console->getIo());
    }

    /**
     * 直接注册一个helper实例
     * 
     * @param string $name
     * @param HelperInterface $helper
     */
    function register($name, HelperInterface $helper)
    {
        $this->loaded[$name] = $helper;
    }
}