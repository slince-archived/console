<?php
namespace Slince\Console\Question;

class ConfirmQuestion extends Question
{

    protected $trueRegex = '#^y#i';

    function __construct($question, $default = null, $trueRegex = null)
    {
        parent::__construct($question, $default);
        if (! is_null($trueRegex)) {
            $this->trueRegex = $trueRegex;
        }
        $this->setNormalizer([$this, 'normalize']);
    }

    function setTrueRegex($trueRegex)
    {
        $this->trueRegex = $trueRegex;
    }
    
    function normalize($answer)
    {
        if (is_bool($answer)) {
            return $answer;
        }
        return (bool)preg_match($this->trueRegex, $answer);
    }
}