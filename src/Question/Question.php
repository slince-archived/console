<?php
namespace Slince\Console\Question;

class Question implements  QuestionInterface
{
    protected $question;
    
    protected $default;
    
    function __construct($question, $default = null)
    {
        $this->question = $question;
        $this->default = $default;
    }
    
    function setQuestion($question)
    {
        $this->question = $question;
    }
    function  getQuestion()
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
    
    function __toString()
    {
        return $this->question;
    }
}