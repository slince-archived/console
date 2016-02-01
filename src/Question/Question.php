<?php
namespace Slince\Console\Question;

use Slince\Console\Exception\LogicException;

class Question implements QuestionInterface
{

    protected $question;

    protected $default;
    
    protected $maxAttempts = 0;
    
    protected $validator;
    
    protected $normalizer;

    function __construct($question, $default = null)
    {
        $this->question = $question;
        $this->default = $default;
    }

    function setQuestion($question)
    {
        $this->question = $question;
    }

    function getQuestion()
    {
        return $this->question;
    }

    function setDefault($default)
    {
        $this->default = $default;
    }

    function getDefault()
    {
        return $this->default;
    }

    function setMaxAttempts($attempts)
    {
        $this->maxAttempts = $attempts;
    }
    
    function getMaxAttempts()
    {
        return $this->maxAttempts;
    }
    
    function reduceMaxAttempts($step = 1)
    {
        $this->maxAttempts -= $step;
    }
    
    function setValidator($validator)
    {
        if (! is_callable($validator)) {
            throw new LogicException('Validator have to be callable');
        }
        $this->validator = $validator;
    }
    
    function getValidator()
    {
        return $this->validator;
    }
    
    function setNormalizer($normalizer)
    {
        if (! is_callable($normalizer)) {
            throw new LogicException('Normalizer have to be callable');
        }
        $this->normalizer = $normalizer;
    }
    
    function getNormalizer()
    {
        return $this->normalizer;
    }
    
    function __toString()
    {
        return $this->question;
    }
}