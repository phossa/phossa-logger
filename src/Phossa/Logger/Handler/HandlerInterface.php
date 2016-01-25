<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Logger\Handler;

use Phossa\Logger\LogEntryInterface;

/**
 * HandlerInterface
 *
 * @interface
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface HandlerInterface
{
    /**
     * Is handling this log level ?
     *
     * @param  string $level log level
     * @return bool
     * @throws Phossa\Logger\Exception\InvalidArgumentException
     *         if $level not right
     * @access public
     * @see    \Phossa\Logger\LogLevel::getLevelCode
     * @api
     */
    public function isHandling(/*# string */ $level)/*# : bool */;

    /**
     * Set log level to handle for this handler
     *
     * Normally used in constructor
     *
     * @param  string $level level to handle
     * @return void
     * @throws \Phossa\Logger\Exception\InvalidArgumentException
     *         if $level not right
     * @see    \Phossa\Logger\LogLevel
     * @access public
     * @api
     */
    public function setHandleLevel(/*# string */ $level);

    /**
     * Get current handling level code in int
     *
     * @param  void
     * @return int
     * @throws void
     * @access public
     * @api
     */
    public function getHandleLevelCode()/*# : int */;

    /**
     * Make this callable
     *
     * class implementing this interface has to define the magic method
     * __invoke(), which takes a \Phossa\Logger\LogEntryInterface object
     * as parameter and also return the same LogEntryInterface object
     *
     * @param  LogEntryInterface $log the log entry
     * @return LogEntryInterface
     * @access public
     * @api
     */
    public function __invoke(LogEntryInterface $log)/*# : LogEntryInterface */;
}
