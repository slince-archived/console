<?php
namespace Slince\Console\Formatter;

use Slince\Console\Exception\InvalidArgumentException;
use Slince\Console\Formatter\Label;

abstract class FormatterStyle
{

    protected static $registerLabels = [
        'success' => '\\Slince\\Console\\Formatter\\Label',
        'error' => '\\Slince\\Console\\Formatter\\Label',
        'warning' => '\\Slince\\Console\\Formatter\\Label',
        'info' => '\\Slince\\Console\\Formatter\\Label'
    ];

    protected $labels;
    
    protected $formatter;

    function __construct()
    {
        $this->formatter = new Formatter();
        $this->configureLabelStyle();
    }

    protected static function registerLabel($name, $className)
    {
        self::$registerLabels[$name] = $className;
    }

    /**
     * 获取标签
     *
     * @param strng $name
     * @throws InvalidArgumentException
     * @return Label
     */
    function getLabel($name)
    {
        if (isset($this->labels[$name])) {
            return $this->labels[$name];
        }
        if (! isset(self::$registerLabels[$name])) {
            throw new InvalidArgumentException(sprintf('Invalid label specified: "%s". Expected one of (%s)', $name, implode(', ', array_keys(self::$registerLabels))));
        }
        return $this->labels[$name] = new self::$registerLabels[$name]();
    }

    function createLabel($name)
    {
        return $this->labels[$name] = new Label();
    }

    function getAvaliableLabels()
    {
        return array_keys(self::$registerLabels) +
            array_keys($this->labels);
    }
    
    function applyLabelStyle($name, $message)
    {
        $label = $this->getLabel($name);
        if ($color = $label->getBackgroundColor() != null) {
            $this->formatter->setBackgroundColor($color);
        }
        if ($color = $label->getForegroundColor() != null) {
            $this->formatter->setForegroundColor($color);
        }
        if ($fontStyles = $label->getFontStyles()) {
            $this->formatter->setFontStyles($fontStyles);
        }
        return $this->formatter->apply($message);
    }
    
    function stylize2($message)
    {
        $tagRegex = implode('|', $this->getAvaliableLabels());
        preg_match_all("#<(($tagRegex) | /($tagRegex)?)>#ix", $message, $matches, PREG_OFFSET_CAPTURE);
        $beginPositions = [];
        $positions = [];
        foreach ($matches[1] as $key => $match) {
            list($label,) = $match;
            $label = ltrim($label, '/');
            if (! isset($positions[$label])) {
                $beginPositions[$label] = [];
                $positions[$label] = [];
            }
            $beginPositions[$label][] = $matches[0][$key][1];
            $positions[$label][] = $matches[0][$key][1] + strlen($matches[0][$key][0]);
        }
        $formatedValues = [];
        $messageFormatPattern = $message;
        foreach ($positions as $label => $position) {
            $formatedValues[] = $this->applyLabelStyle($label, substr($message, $position[0], $beginPositions[$label][1] - $position[0]));
            $messageFormatPattern = substr_replace($messageFormatPattern, '%s',
                $beginPositions[$label][0],
                $position[1] - $beginPositions[$label][0]
            );
        }
        return vsprintf($messageFormatPattern, $formatedValues);
    }
    
    function stylize($message)
    {
        $tagRegex = implode('|', $this->getAvaliableLabels());
        preg_match_all("#<(($tagRegex) | /($tagRegex)?)>#ix", $message, $matches, PREG_OFFSET_CAPTURE);
        $processedMessage = '';
        $start = 0;
        $open = false;
        foreach ($matches[0] as $key => $match) {
            $label = $matches[1][$key][0];
            $text = $match[0];
            $pos = $match[1];
            if ($pos == 0) {
                continue;
            }
            if ($label{0} != '/') {
                $open = true;
            }
            $length = $pos - $start;
            $processedMessage .= $this->applyLabelStyle($label, substr($message, $start, $length));
            $start += strlen($match[0]);
        }
    }
    abstract function configureLabelStyle();
}