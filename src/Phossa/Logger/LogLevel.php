<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Logger;

use Psr\Log\LogLevel as PsrLogLevel;
use Phossa\Logger\Message\Message;

/**
 * LogLevel
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
class LogLevel extends PsrLogLevel
{
    use \Phossa\Shared\Pattern\StaticTrait;

    /**
     * log level mappings
     *
     * @var     array
     * @type    array
     * @access  protected
     * @static
     */
    protected static $levels = [
        PsrLogLevel::DEBUG      => 10,
        PsrLogLevel::INFO       => 20,
        PsrLogLevel::NOTICE     => 30,
        PsrLogLevel::WARNING    => 40,
        PsrLogLevel::ERROR      => 50,
        PsrLogLevel::CRITICAL   => 60,
        PsrLogLevel::ALERT      => 70,
        PsrLogLevel::EMERGENCY  => 80
    ];

    /**
     * Get level code by name
     *
     * @param  string $level level name
     * @return int
     * @access public
     * @throws Exception\InvalidArgumentException
     *         if $throwException and not the right level name
     * @static
     * @api
     */
    public static function getLevelCode(
        /*# string */ $level
    )/*# : int */ {
        if (is_string($level) &&
            isset(self::$levels[$level])) {
            return self::$levels[$level];
        }

        throw new Exception\InvalidArgumentException(
            Message::get(
                Message::INVALID_LOG_LEVEL,
                (string) $level
            ),
            Message::INVALID_LOG_LEVEL
        );
    }
}
