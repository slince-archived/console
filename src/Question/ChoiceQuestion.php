<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */
namespace Slince\Console\Question;

use Slince\Console\Exception\InvalidArgumentException;

class ChoiceQuestion extends Question
{

    /**
     * 候选项
     * 
     * @var array
     */
    protected $choices = [];

    /**
     * 是否是多选
     * 
     * @var boolean
     */
    protected $multiSelect;

    /**
     * 多选项间隔符
     * 
     * @var string
     */
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

    /**
     * 设置候选项
     * 
     * @param array $choices
     */
    function setChoices(array $choices)
    {
        $this->choices = $choices;
    }

    /**
     * 获取所有候选项
     * 
     * @return array
     */
    function getChoices()
    {
        return $this->choices;
    }

    /**
     * 设置是否多选
     * 
     * @param boolean $multiSelect
     */
    function setMultiSelect($multiSelect)
    {
        $this->multiSelect = (bool)($multiSelect);
    }
    
    /**
     * 获取是否多选
     * 
     * @return boolean
     */
    function getMultiSelect()
    {
        return $this->multiSelect;
    }
    
    /**
     * 设置多选项分隔符
     * 
     * @param string $glue
     */
    function setMultiAnswerGlue($glue)
    {
        $this->multiAnswerGlue = $glue;
    }

    /**
     * 获取多选项分隔符
     * 
     * @return string
     */
    function getMultiAnswerGlue()
    {
        return $this->multiAnswerGlue;
    }

    /**
     * 验证用户回答
     * 
     * @param string $answer
     * @throws InvalidArgumentException
     * @return string|array
     */
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

    /**
     * 获取用户实际选项
     * 
     * @param string|int $choice
     * @return boolean|string
     */
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