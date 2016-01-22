<?php
namespace Slince\Console\Helper;

use Slince\Console\Question\QuestionInterface;

class QuestionHelper extends Helper
{
    
    function ask(QuestionInterface $question)
    {
        $this->writeQuestionMessage($question);
        $answer = $this->io->in();
        
    }
    
    protected function writeQuestionMessage(QuestionInterface $question)
    {
        $this->io->out($question);
    }
}