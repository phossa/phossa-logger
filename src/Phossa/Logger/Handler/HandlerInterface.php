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
use Phossa\Logger\Formatter\FormatterCapableInterface;

/**
 * HandlerInterface
 *
 * @interface
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface HandlerInterface extends FormatterCapableInterface
{
    /**
     * Is handling this log level ?
     *
     * if argument $level is empty string, returns the level code currently
     * handled by this handler
     *
     * @param  string $level log level
     * @return mixed level code(int) or FALSE
     * @access public
     * @see    Phossa\Logger\LogLevel::getLevelCode
     * @api
     */
    public function isHandling(/*# string */ $level = '');

    /**
     * Set log level to handle for this handler
     *
     * Normally used in constructor
     *
     * @param  string $level level to handle
     * @return void
     * @throws void
     * @access public
     * @api
     */
    public function setHandleLevel(/*# string */ $level);

    /**
     * Make this callable
     * 
     * class implementing this interface has to define the magic method
     * __invoke(), which takes a Phossa\Logger\LogEntryInterface object as
     * parameter and also return the same LogEntryInterface object
     *
     * @param  LogEntryInterface $log the log entry
     * @return LogEntryInterface
     * @access public
     * @api
     */
    public function __invoke(LogEntryInterface $log)/*# : LogEntryInterface */;
}
