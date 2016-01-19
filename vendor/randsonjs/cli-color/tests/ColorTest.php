<?php

use PHPUnit_Framework_TestCase as PHPUnit;
use Colors\Color;

class ColorTest extends PHPUnit
{

    /**
     * undocumented function
     *
     * @return void
     **/
    public function testColorMessage()
    {
        return Color::message('Hey, this a message of test :)');
    }
}
