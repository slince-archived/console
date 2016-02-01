<?php
namespace Slince\Console\Question;

interface QuestionInterface
{

    function setQuestion($question);

    function getQuestion();

    function setDefault($default);

    function getDefault();

    function setMaxAttempts($attempts);

    function getMaxAttempts();

    function reduceMaxAttempts($step = 1);

    function setValidator($validator);

    function getValidator();

    function setNormalizer($normalizer);

    function getNormalizer();
}