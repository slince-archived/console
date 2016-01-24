<?php
namespace Slince\Console;

use Slince\Console\Context\Option;

class CommandCompiler
{

    static function compileOptions(CommandInterface $command)
    {
        $shortOptions = [];
        $longOptions = [];
        foreach ($command->getOptions() as $option) {
            if ($option->isShort()) {
                $shortOptions[] = self::parseOption($option);
            } else {
                $longOptions[] = self::parseOption($option);
            }
        }
        return getopt(implode('', $shortOptions), $longOptions);
    }
    
    protected static function parseOption(Option $option)
    {
        $optionStr = $option->getName();
        if ($option->isValueRequired()) {
            $optionStr .= ':';
        } elseif($option->isValueOptional()) {
            $optionStr .= '::';
        }
        return $optionStr;
    }
}