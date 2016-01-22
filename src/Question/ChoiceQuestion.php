<?php
namespace Slince\Console\Question;

class ChoiceQuestion extends Question
{

    protected $choices = [];
    
    protected $multiSelect;

    function __construct($question, array $choices, $default = null, $multiSelect = false)
    {
        parent::__construct($question, $default);
        $this->$choices = $choices;
        $this->multiSelect = $multiSelect;
    }
    
    function setChoices(array $choices)
    {
        $this->choices = $choices;
    }
    
    function getChoices()
    {
        return $this->choices;
    }
    
    
}