<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Console\Question;

class ConfirmQuestion extends Question
{

    /**
     * 正确答案的验证规则
     * 
     * @var string
     */
    protected $trueRegex = '#^y#i';

    function __construct($question, $default = null, $trueRegex = null)
    {
        parent::__construct($question, $default);
        if (! is_null($trueRegex)) {
            $this->trueRegex = $trueRegex;
        }
        $this->setNormalizer([$this, 'normalize']);
    }

    /**
     * 设置验证规则
     * 
     * @param string $trueRegex
     */
    function setTrueRegex($trueRegex)
    {
        $this->trueRegex = $trueRegex;
    }
    
    /**
     * 修改用户答案
     * 
     * @param string $answer
     * @return boolean
     */
    function normalize($answer)
    {
        if (is_bool($answer)) {
            return $answer;
        }
        return (bool)preg_match($this->trueRegex, $answer);
    }
}