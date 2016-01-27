<?php
namespace Slince\Console\Question;

interface QuestionInterface
{

    function setQuestion($question);

    function getQuestion();

    function setValidator($validator);

    function getValidator();

    function setMaxAttempts($attempts);

    function getMaxAttempts();

    function getDefault();

    function setDefault($default);
    
    function reduceMaxAttempts($step = 1);
}