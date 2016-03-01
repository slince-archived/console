<?php
namespace Slince\Console\Question;

interface QuestionInterface
{

    /**
     * 设置问题
     * 
     * @param string $question
     */
    function setQuestion($question);

    /**
     * 获取问题
     * 
     * @return string
     */
    function getQuestion();

    /**
     * 设置默认答案
     * 
     * @param string $default
     */
    function setDefault($default);

    /**
     * 获取默认答案
     * 
     */
    function getDefault();

    /**
     * 设置最大可尝试的次数
     * 
     * @param int $attempts
     */
    function setMaxAttempts($attempts);

    /**
     * 获取最大可尝试的次数
     * 
     * @return int
     */
    function getMaxAttempts();

    /**
     * 消减尝试次数
     * 
     * @param number $step
     */
    function reduceMaxAttempts($step = 1);

    /**
     * 设置答案验证
     * 
     * @param callable $validator
     */
    function setValidator($validator);

    /**
     * 获取验证处理器
     * @return callable
     */
    function getValidator();

    /**
     * 设置答案修改器
     * 
     * @param callable $normalizer
     */
    function setNormalizer($normalizer);

    /**
     * 获取答案修改器
     * 
     * @return callable
     */
    function getNormalizer();
}