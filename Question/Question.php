<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Console\Question;

use Slince\Console\Exception\LogicException;

class Question implements QuestionInterface
{

    /**
     * 问题主体
     * 
     * @var string
     */
    protected $question;

    /**
     * 默认值
     * 
     * @var mixed
     */
    protected $default;
    
    /**
     * 最大可尝试次数
     * 
     * @var string
     */
    protected $maxAttempts = 0;
    
    /**
     * 验证器
     * 
     * @var callable
     */
    protected $validator;
    
    /**
     * 修改器
     * 
     * @var callable
     */
    protected $normalizer;

    function __construct($question, $default = null)
    {
        $this->question = $question;
        $this->default = $default;
    }

    /**
     * (non-PHPdoc)
     * @see \Slince\Console\Question\QuestionInterface::setQuestion()
     */
    function setQuestion($question)
    {
        $this->question = $question;
    }

    /**
     * (non-PHPdoc)
     * @see \Slince\Console\Question\QuestionInterface::getQuestion()
     */
    function getQuestion()
    {
        return $this->question;
    }

    /**
     * (non-PHPdoc)
     * @see \Slince\Console\Question\QuestionInterface::setDefault()
     */
    function setDefault($default)
    {
        $this->default = $default;
    }

    /**
     * (non-PHPdoc)
     * @see \Slince\Console\Question\QuestionInterface::getDefault()
     */
    function getDefault()
    {
        return $this->default;
    }

    /**
     * (non-PHPdoc)
     * @see \Slince\Console\Question\QuestionInterface::setMaxAttempts()
     */
    function setMaxAttempts($attempts)
    {
        $this->maxAttempts = $attempts;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Slince\Console\Question\QuestionInterface::getMaxAttempts()
     */
    function getMaxAttempts()
    {
        return $this->maxAttempts;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Slince\Console\Question\QuestionInterface::reduceMaxAttempts()
     */
    function reduceMaxAttempts($step = 1)
    {
        $this->maxAttempts -= $step;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Slince\Console\Question\QuestionInterface::setValidator()
     */
    function setValidator($validator)
    {
        if (! is_callable($validator)) {
            throw new LogicException('Validator have to be callable');
        }
        $this->validator = $validator;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Slince\Console\Question\QuestionInterface::getValidator()
     */
    function getValidator()
    {
        return $this->validator;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Slince\Console\Question\QuestionInterface::setNormalizer()
     */
    function setNormalizer($normalizer)
    {
        if (! is_callable($normalizer)) {
            throw new LogicException('Normalizer have to be callable');
        }
        $this->normalizer = $normalizer;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Slince\Console\Question\QuestionInterface::getNormalizer()
     */
    function getNormalizer()
    {
        return $this->normalizer;
    }
    
    function __toString()
    {
        return $this->question;
    }
}