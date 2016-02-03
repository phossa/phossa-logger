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

namespace Phossa\Logger;

/**
 * LogEntryInterface
 *
 * @interface
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.4
 * @since   1.0.0 added
 * @since   1.0.1 removed stopCascading() etc.
 */
interface LogEntryInterface
{
    /**
     * Set log message
     *
     * @param  string $message the original message string
     * @return LogEntryInterface $this
     * @access public
     * @api
     */
    public function setMessage(
        /*# string */ $message
    )/*# : LogEntryInterface */;

    /**
     * Get the original message
     *
     * @return string
     * @access public
     * @api
     */
    public function getMessage()/*# : string */;

    /**
     * Set log level
     *
     * @param  string $level string constant
     * @return LogEntryInterface $this
     * @access public
     * @throws Exception\InvalidArgumentException if invalid level given
     * @see    \Phossa\Logger\LogLevel
     * @api
     */
    public function setLevel(
        /*# string */ $level = LogLevel::INFO
    )/*# : LogEntryInterface */;

    /**
     * Get message level
     *
     * @return string
     * @access public
     * @see    \Phossa\Logger\LogLevel
     * @api
     */
    public function getLevel()/*# : string */;

    /**
     * Set timestamp, default is current UNIX timestamp in float
     *
     * @param  float $timestamp UNIX time in float
     * @return LogEntryInterface $this
     * @access public
     * @see    microtime()
     * @api
     */
    public function setTimestamp(
        /*# : float */ $timestamp = 0
    )/*# : LogEntryInterface */;

    /**
     * Get timestamp
     *
     * @return float
     * @access public
     * @api
     */
    public function getTimestamp()/*# : float */;

    /**
     * Set log related contexts
     *
     * @param  array $context
     * @return LogEntryInterface $this
     * @access public
     * @api
     */
    public function setContexts(array $context)/*# : LogEntryInterface */;

    /**
     * Get log context array
     *
     * @return array
     * @access public
     * @api
     */
    public function getContexts()/*# : array */;

    /**
     * Set log specific context
     *
     * @param  string $name context name
     * @param  mixed $value context value
     * @return LogEntryInterface $this
     * @access public
     * @api
     */
    public function setContext(
        /*# string */ $name,
        $value
    )/*# : LogEntryInterface */;

    /**
     * Get log specific context, return NULL if not found
     *
     * @param  string $name context name
     * @return mixed
     * @access public
     * @api
     */
    public function getContext(/*# string */ $name);

    /**
     * To string
     *
     * @return string
     * @access public
     * @api
     */
    public function __toString()/*# : string */;
}
