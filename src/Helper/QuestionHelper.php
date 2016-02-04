<?php
namespace Slince\Console\Helper;

use Slince\Console\Question\QuestionInterface;

class QuestionHelper extends Helper
{

    function ask(QuestionInterface $question)
    {
        if ($question->getValidator() == null) {
            $answer = $this->processAsk($question);
        }
        return $this->validateAttempts($question);
    }

    function processAsk(QuestionInterface $question)
    {
        $this->io->write($question);
        $answer = $this->io->read();
        if ($answer == '') {
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
        do {
            $answer = $this->processAsk($question);
            try {
                return call_user_func($question->getValidator(), $answer);
            } catch (\Exception $e) {
                $this->io->writeln($e->getMessage());
            }
            $question->reduceMaxAttempts();
        } while ($question->getMaxAttempts() > 0);
        return $e;
    }
}