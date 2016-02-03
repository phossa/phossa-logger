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

namespace Phossa\Logger\Handler;

use Phossa\Logger\LogEntryInterface;

/**
 * HandlerInterface
 *
 * <code>
 *     $handler = new Handler();
 *
 *     // set formatter. if not set, use the DefaultFormatter
 *     $handler->setFormatter(new Formatter\AnsiFormatter());
 *
 *     // handle the entry
 *     $handler($logEntry);
 *
 *     // stop this handler
 *     $handler->stopHandler();
 *
 *     // stop bubbling up the $logEntry
 *     $handler->stopBubbling();
 * </code>
 *
 * @interface
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.4
 * @since   1.0.0 added
 * @since   1.0.1 __invoke() returns void now
 * @since   1.0.4 added startHandler()/startBubbling()
 */
interface HandlerInterface
{
    /**
     * Is handling this log level ?
     *
     * @param  string $level log level
     * @return bool
     * @throws \Phossa\Logger\Exception\InvalidArgumentException
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
     * @return int
     * @access public
     * @api
     */
    public function getHandleLevelCode()/*# : int */;

    /**
     * Stop this handler, bypass this handler
     *
     * @return void
     * @access public
     * @api
     */
    public function stopHandler();

    /**
     * Start/enable this handler
     *
     * @return void
     * @access public
     * @api
     */
    public function startHandler();

    /**
     * Is this handler stopped
     *
     * @return bool
     * @access public
     * @api
     */
    public function isHandlerStopped()/*# : bool */;

    /**
     * stop bubbling up
     *
     * @return void
     * @access public
     * @api
     */
    public function stopBubbling();

    /**
     * start/enable bubbling up
     *
     * @return void
     * @access public
     * @api
     */
    public function startBubbling();

    /**
     * Is bubbling stopped
     *
     * @return bool
     * @access public
     * @api
     */
    public function isBubblingStopped()/*# : bool */;

    /**
     * Make this callable
     *
     * class implementing this interface has to define the magic method
     * __invoke(), which takes a \Phossa\Logger\LogEntryInterface object
     * as parameter.
     *
     * @param  LogEntryInterface $log the log entry
     * @return void
     * @access public
     * @api
     */
    public function __invoke(LogEntryInterface $log);
}
