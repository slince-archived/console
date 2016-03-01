<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Console\Context;

class Argument
{

    /**
     * 不需要值
     * 
     * @var int
     */
    const VALUE_NONE = 1;

    /**
     * 需要值
     *
     * @var int
     */
    const VALUE_REQUIRED = 2;

    /**
     * 可选值
     *
     * @var int
     */
    const VALUE_OPTIONAL = 4;

    /**
     * 名称
     * 
     * @var string
     */
    protected $name;

    /**
     * 值模式
     * 
     * @var int
     */
    protected $valueMode;

    /**
     * 描述
     * 
     * @var string
     */
    protected $description;

    /**
     * 默认值
     * 
     * @var mixed
     */
    protected $default;

    function __construct($name, $valueMode, $description = null, $default = null)
    {
        $this->name = $name;
        $this->valueMode = $valueMode;
        $this->description = $description;
        $this->default = $default;
    }

    /**
     * 获取名称
     * 
     * @return string
     */
    function getName()
    {
        return $this->name;
    }

    /**
     * 是否一定需要值
     * 
     * @return boolean
     */
    function isValueRequired()
    {
        return $this->valueMode === self::VALUE_REQUIRED;
    }

    /**
     * 是否是可选值
     * 
     * @return boolean
     */
    function isValueOptional()
    {
        return $this->valueMode === self::VALUE_OPTIONAL;
    }

    /**
     * 获取描述
     * 
     * @return string
     */
    function getDescription()
    {
        return $this->description;
    }

    /**
     * 获取默认值
     * 
     * @return mixed
     */
    function getDefault()
    {
        return $this->default;
    }
}