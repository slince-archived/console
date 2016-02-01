<?php
namespace Slince\Console\Helper;

use Slince\Console\Question\QuestionInterface;

class QuestionHelper extends Helper
{

    function ask(QuestionInterface $question)
    {
        if ($question->getValidator() == null) {
            return $this->processAsk($question);
        }
        return $this->validateAttempts($question);
    }

    function processAsk(QuestionInterface $question)
    {
        $this->io->out($question->getQuestion());
        $answer = $this->io->in();
        if (empty($answer)) {
            $answer = $question->getDefault();
        }
        if (($normalizer = $question->getNormalizer()) != null) {
            return call_user_func($normalizer, $answer);
        }
        return $answer;
    }

    protected function validateAttempts(QuestionInterface $question)
    {
        $e = null;
        while ($question->getMaxAttempts() > 0) {
            $answer = $this->processAsk($question);
            try {
                if (call_user_func($question->getValidator(), $answer)) {
                    return $answer;
                }
            } catch (\Exception $e) {}
            $question->reduceMaxAttempts();
        }
        return $e;
    }
}