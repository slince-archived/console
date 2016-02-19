<?php
/**
 * slince console component
 * @author Tao <taosikai@yeah.net>
 */

namespace Slince\Console\Helper;

use Slince\Console\Context\Io;

class Helper implements HelperInterface
{
    /**
     * io
     * 
     * @var Io
     */
    protected $io;
    
    function __construct(Io $io = null)
    {
        $this->io = $io;
    }
}