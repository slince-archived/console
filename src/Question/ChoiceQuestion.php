<?php
namespace Slince\Console\Question;

use Slince\Console\Exception\InvalidArgumentException;

class ChoiceQuestion extends Question
{

    protected $choices = [];

    protected $multiSelect;

    protected $multiAnswerGlue = ',';

    protected $errorMessage = 'Value "%s" is invalid';

    function __construct($question, array $choices, $default = null, $multiSelect = false)
    {
        parent::__construct($question, $default);
        $this->choices = $choices;
        $this->multiSelect = $multiSelect;
        $this->setValidator([
            $this,
            'validate'
        ]);
    }

    function __toString()
    {
        $message = [
            $this->question
        ];
        $keyMaxWidth = max(array_map('strlen', array_keys($this->choices)));
        foreach ($this->choices as $key => $choice) {
            $message[] = sprintf("  <info>%-{$keyMaxWidth}s</info> %s", $key, $choice);
        }
        $message[] = ' > ';
        return implode(PHP_EOL, $message);
    }

    function setChoices(array $choices)
    {
        $this->choices = $choices;
    }

    function getChoices()
    {
        return $this->choices;
    }

    function setMultiSelect($multiSelect)
    {
        $this->multiSelect = (bool)($multiSelect);
    }
    
    function getMultiSelect()
    {
        return $this->multiSelect;
    }
    
    function setMultiAnswerGlue($glue)
    {
        $this->multiAnswerGlue = $glue;
    }

    function getMultiAnswerGlue()
    {
        return $this->multiAnswerGlue;
    }

    function validate($answer)
    {
        if ($this->multiSelect) {
            $choices = explode($this->multiAnswerGlue, $answer);
            $errorChoices = [];
            $resultChoices = [];
            foreach ($choices as $key => $choice) {
                if (($actualChoice = $this->getActualChoice($choice)) !== false) {
                    $resultChoices[] = $actualChoice;
                } else {
                    $errorChoices[] = $choice;
                }
            }
            if (! empty($errorChoices)) {
                throw new InvalidArgumentException(sprintf('The provided answer "\s", is ambiguous. Value should be one of %s.', 
                    implode($this->multiAnswerGlue, $errorChoices), implode(' or ', $this->choices)));
            }
            return $resultChoices;
        } else {
            if (($actualChoice = $this->getActualChoice($answer)) === false) {
                throw new InvalidArgumentException(sprintf($this->errorMessage, $answer));
            }
            return $actualChoice;
        }
    }

    protected function getActualChoice($choice)
    {
        if (! in_array($choice, $this->choices)) {
            if (isset($this->choices[$choice])) {
                $choice = $this->choices[$choice];
            } else {
                return false;
            }
        }
        return $choice;
    }
}