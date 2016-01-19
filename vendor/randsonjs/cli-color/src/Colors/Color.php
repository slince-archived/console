<?php 
namespace Color;

class Color2
{
    /**
     * Declares regular colors to display on the terminal
     *
     * @var array
     **/
    static $regular = array(
        'Black'        => "\e[0;30m",
        'Red'          => "\e[0;31m",
        'Green'        => "\e[0;32m",
        'Yellow'       => "\e[0;33m",
        'Blue'         => "\e[0;34m",
        'Purple'       => "\e[0;35m",
        'Cyan'         => "\e[0;36m",
        'White'        => "\e[0;37m"
    );

    /**
     * Declares bold colors to display on the terminal
     *
     * @var array
     **/
    static $bold = array(
        'Black'        => "\e[1;30m",
        'Red'          => "\e[1;31m",
        'Green'        => "\e[1;32m",
        'Yellow'       => "\e[1;33m",
        'Blue'         => "\e[1;34m",
        'Purple'       => "\e[1;35m",
        'Cyan'         => "\e[1;36m",
        'White'        => "\e[1;37m"
    );

    /**
     * Declares underline colors to display on the terminal
     *
     * @var array
     **/
    static $underline = array(
        'Black'        => "\e[4;30m",
        'Red'          => "\e[4;31m",
        'Green'        => "\e[4;32m",
        'Yellow'       => "\e[4;33m",
        'Blue'         => "\e[4;34m",
        'Purple'       => "\e[4;35m",
        'Cyan'         => "\e[4;36m",
        'White'        => "\e[4;37m"
    );

    /**
     * Declares background colors
     *
     * @var string
     **/
    static $background = array(
        'Black'        => "\e[40m",
        'Red'          => "\e[41m",
        'Green'        => "\e[42m",
        'Yellow'       => "\e[43m",
        'Blue'         => "\e[44m",
        'Purple'       => "\e[45m",
        'Cyan'         => "\e[46m",
        'White'        => "\e[47m"
    );

    /**
     * Create a new color message
     *
     * @param string $color
     * @param string $message
     * @return void
     **/
    public function apply($color = 'White', $message)
    {
        return self::$bold[$color] . $message;
    }

    /**
     * Return a message in bold font
     *
     * @param string
     * @return string
     **/
    public function message($message)
    {
        return self::apply($message);
    }

    /**
     * Return a success message in bold font
     *
     * @param string
     * @return string
     **/
    public function success($message)
    {
        return self::apply('Green', $message);
    }

    /**
     * Return a info message in bold font
     *
     * @param string
     * @return string
     **/
    public function info($message)
    {
        return self::apply('Cyan', $message);
    }

    /**
     * Return a warning message in bold font
     *
     * @param string
     * @return string
     **/
    public function warning($message)
    {
        return self::apply('Yellow', $message);
    }

    /**
     * Return a danger message in bold font
     *
     * @param string
     * @return string
     **/
    public function danger($message)
    {
        return self::apply('Red', $message);
    }
}
