<?php
/**
 * Phossa Project
 *
 * PHP version 5.4
 *
 * @category  Package
 * @package   Phossa\Logger
 * @author    Hong Zhang <phossa@126.com>
 * @copyright 2015 phossa.com
 * @license   http://mit-license.org/ MIT License
 * @link      http://www.phossa.com/
 */
/*# declare(strict_types=1); */

namespace Phossa\Logger\Formatter;

use Phossa\Logger\LogLevel;
use Phossa\Logger\LogEntryInterface;

/**
 * AnsiFormatter
 *
 * Adding ANSI color to any formatter(slave) result
 *
 * <code>
 *     $ansiColor = new AnsiFormatter();
 *     $ansiColor->setSlave(new DefaultFormatter());
 * </code>
 *
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.4
 * @since   1.0.1 added
 */
class AnsiFormatter extends FormatterAbstract
{
    // <editor-fold defaultstate="collapsed" desc="colors">
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
     * Color definitions for different log levels
     *
     * format  [ fgColor, bgColor, textDeco ]
     *
     * @var     array
     * @access  protected
     */
    protected $colors = array(
        LogLevel::DEBUG     => [ self::FGCOLOR_GRAY,  null, null ],
        LogLevel::INFO      => [ null, null, null ],
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

    // </editor-fold>

    /**
     * Slave formatter
     *
     * @var    FormatterInterface
     * @access protected
     */
    protected $slave;

    /**
     * Set slave formatter
     *
     * @param  FormatterInterface $formatter the normal formatter
     * @return void
     * @access public
     * @api
     */
    public function setSlave(FormatterInterface $formatter)
    {
        $this->slave = $formatter;
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(LogEntryInterface $log)/*# : string */
    {
        // check slave first
        if (is_null($this->slave)) {
            $this->setSlave(new DefaultFormatter());
        }

        return $this->addColor(
            call_user_func($this->slave, $log),
            $this->colors[$log->getLevel()] // color definition
        );
    }

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
        $fgColor = $definition[0] ?: '';
        $bgColor = $definition[1] ?: '';
        $deColor = $definition[2] ?: '';
        $prefix  = $fgColor . $bgColor . $deColor;
        $suffix  = $prefix ? self::DECO_END : '';
        return $prefix . $text . $suffix;
    }
}
