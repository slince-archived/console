<?php
namespace Slince\Console\Question;

use Slince\Console\Exception\InvalidArgumentException;

class ChoiceQuestion extends Question
{

    protected $choices = [];

    protected $multiSelect;

    protected $multiAnswerGlue = ',';

    function __construct($question, array $choices, $default = null, $multiSelect = false)
    {
        parent::__construct($question, $default);
        $this->$choices = $choices;
        $this->multiSelect = $multiSelect;
        $this->setValidator([$this, 'validate']);
    }

    function setChoices(array $choices)
    {
        $this->choices = $choices;
    }

    function getChoices()
    {
        return $this->choices;
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
        if (! $this->multiSelect) {
            return is_array($answer, $this->choices);
        }
        $choices = explode($this->multiAnswerGlue, $answer);
        foreach ($choices as $choice) {
            if (in_array($choice, $choices)) {
                continue;
            }
            throw new InvalidArgumentException(sprintf('The provided answer "\s", is ambiguous. Value should be one of %s.', $choice, implode(' or ', $results)));
        }
        return true;
    }
}