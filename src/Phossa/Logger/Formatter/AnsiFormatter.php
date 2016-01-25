<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Logger\Formatter;

use Phossa\Logger\LogLevel;
use Phossa\Logger\LogEntryInterface;

/**
 * AnsiFormatter
 *
 * Print with ANSI color
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.1
 * @since   1.0.1 added
 */
class AnsiFormatter extends DefaultFormatter
{
    /**
     * foreground color
     *
     * @const
     */
    const FGCOLOR_BLACK          = "\033[0;30m";
    const FGCOLOR_RED            = "\033[0;31m";
    const FGCOLOR_GREEN          = "\033[0;32m";
    const FGCOLOR_YELLOW         = "\033[0;33m";
    const FGCOLOR_BLUE           = "\033[0;34m";
    const FGCOLOR_MAGENTA        = "\033[0;35m";
    const FGCOLOR_CYAN           = "\033[0;36m";
    const FGCOLOR_GRAY           = "\033[0;37m";
    const FGCOLOR_DARK_GRAY      = "\033[1;30m";
    const FGCOLOR_BRIGHT_RED     = "\033[1;31m";
    const FGCOLOR_BRIGHT_GREEN   = "\033[1;32m";
    const FGCOLOR_BRIGHT_YELLOW  = "\033[1;33m";
    const FGCOLOR_BRIGHT_BLUE    = "\033[1;34m";
    const FGCOLOR_BRIGHT_MAGENTA = "\033[1;35m";
    const FGCOLOR_BRIGHT_CYAN    = "\033[1;36m";
    const FGCOLOR_WHITE          = "\033[1;37m";

    /**
     * background color
     *
     * @const
     */
    const BGCOLOR_BLACK          = "\033[40m";
    const BGCOLOR_RED            = "\033[41m";
    const BGCOLOR_GREEN          = "\033[42m";
    const BGCOLOR_YELLOW         = "\033[43m";
    const BGCOLOR_BLUE           = "\033[44m";
    const BGCOLOR_MAGENTA        = "\033[45m";
    const BGCOLOR_CYAN           = "\033[46m";
    const BGCOLOR_WHITE          = "\033[47m";

    const DECO_BOLD              = "\033[1m";
    const DECO_UNDERLINE         = "\033[4m";
    const DECO_BLINK             = "\033[5m";
    const DECO_REVERSE           = "\033[7m";
    const DECO_CROSS             = "\033[9m";
    const DECO_END               = "\033[0m";

    /**
     * format  [ fgColor, bgColor, textDeco ]
     *
     * @access  protected
     * @type    array
     */
    protected $colors = array(
        LogLevel::DEBUG     => [ self::FGCOLOR_GRAY,  null, null ],
        LogLevel::INFO      => [ self::FGCOLOR_WHITE, null, null ],
        LogLevel::NOTICE    => [ self::FGCOLOR_BRIGHT_GREEN, null, null ],
        LogLevel::WARNING   => [ self::FGCOLOR_BRIGHT_YELLOW, null, null ],
        LogLevel::ERROR     => [ self::FGCOLOR_BRIGHT_RED, null, null ],
        LogLevel::CRITICAL  => [
            self::FGCOLOR_BRIGHT_RED, null, self::DECO_UNDERLINE
        ],
        LogLevel::ALERT     => [
            self::FGCOLOR_BRIGHT_RED, self::BGCOLOR_WHITE, null
        ],
        LogLevel::EMERGENCY => [
            self::FGCOLOR_BRIGHT_RED, self::BGCOLOR_WHITE, self::DECO_BLINK
        ],
    );

    /**
     * add ansi color to text
     *
     * @param  string $text text to color
     * @param  array $definition coloring definition
     * @return string
     * @access protected
     */
    protected function addColor(
        /*# string */ $text,
        array $definition
    )/*# : string */ {
        $fg = $definition[0] ?: '';
        $bg = $definition[1] ?: '';
        $de = $definition[2] ?: '';
        $prefix = $fg . $bg . $de;
        $suffix = $prefix ? self::DECO_END : '';
        return $prefix . $text . $suffix;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(LogEntryInterface $log)/*# : string */
    {
        return $this->addColor(
            parent::__invoke($log),
            $this->colors[$log->getLevel()] // color definition
        );
    }
}
