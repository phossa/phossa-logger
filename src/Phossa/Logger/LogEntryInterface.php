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

/**
 * LogEntryInterface
 *
 * @interface
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
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
     * @param  void
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
     * @api
     */
    public function setLevel(
        /*# string */ $level = LogLevel::INFO
    )/*# : LogEntryInterface */;

    /**
     * Get message level
     *
     * @param  void
     * @return string
     * @access public
     * @api
     */
    public function getLevel()/*# : string */;

    /**
     * Set timestamp, default is current timestamp
     *
     * @param  float $timestamp UNIX time in float
     * @return LogEntryInterface $this
     * @access public
     * @api
     */
    public function setTimestamp(
        /*# : float */ $timestamp = 0
    )/*# : LogEntryInterface */;

    /**
     * Get timestamp
     *
     * @param  void
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
     * @param  void
     * @return array
     * @access public
     * @api
     */
    public function getContexts()/*# : array */;

    /**
     * Merge with new context
     *
     * @param  array $context new context array to merge with
     * @return LogEntryInterface $this
     * @access public
     * @api
     */
    public function mergeContexts(array $context);

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
     * Set formatted string
     *
     * @param  string $formatted formatted message string
     * @return LogEntryInterface $this
     * @access public
     * @api
     */
    public function setFormatted(/*# string */ $formatted)/*# : LogEntryInterface */;

    /**
     * Get formatted string
     *
     * @param  void
     * @return mixed null or string
     * @access public
     * @api
     */
    public function getFormatted();

    /**
     * Set log entry cascade downwards
     *
     * @param  bool $stop stop bubbling
     * @return void
     * @access public
     * @api
     */
    public function stopCascading(/*# bool */ $stop = true);

    /**
     * Get current cascading status
     *
     * @param  void
     * @return bool
     * @access public
     * @api
     */
    public function isCascadingStopped();
}
