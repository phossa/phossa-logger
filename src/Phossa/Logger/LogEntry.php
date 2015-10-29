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

use Phossa\Logger\Formatter\DefaultFormatter;

/**
 * Log entry class
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
class LogEntry implements LogEntryInterface
{
    /**
     * message string
     *
     * @var    string
     * @type   string
     * @access protected
     */
    protected $message;

    /**
     * log level
     *
     * @var    string
     * @type   string
     * @access protected
     */
    protected $level;

    /**
     * UTC Unix timestamp
     *
     * @var    float
     * @type   float
     * @access protected
     */
    protected $timestamp;

    /**
     * contexts
     *
     * @var    array
     * @type   array
     * @access protected
     */
    protected $context;

    /**
     * the formatted string
     *
     * @var    string
     * @type   string
     * @access protected
     */
    protected $formatted;

    /**
     * Cascading status
     *
     * @var    bool
     * @type   bool
     * @access protected
     */
    protected $stopped = false;

    /**
     * Constructor
     *
     * @param  string $level message level
     * @param  string $message message
     * @param  array $contexts message context
     * @access public
     * @api
     */
    public function __construct(
        /*# string */ $level,
        /*# string */ $message,
        array $contexts = []
    ) {
        $this->setMessage($message)
             ->setLevel($level)
             ->setTimestamp()
             ->setContexts($contexts);
    }

    /**
     * {@inheritDoc}
     */
    public function setMessage(
        /*# string */ $message
    )/*# : LogEntryInterface */ {
        $this->message = $message;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getMessage()/*# : string */ {
        return $this->message;
    }

    /**
     * {@inheritDoc}
     */
    public function setLevel(
        /*# string */ $level = LogLevel::INFO
    )/*# : LogEntryInterface */ {
        $this->level = $level;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getLevel()/*# : string */ {
        return $this->level;
    }

    /**
     * {@inheritDoc}
     */
    public function setTimestamp(
        /*# : float */ $timestamp = 0
    )/*# : LogEntryInterface */ {
        $this->timestamp = $timestamp ?: microtime(true);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getTimestamp()/*# : float */ {
        return $this->timestamp;
    }

    /**
     * {@inheritDoc}
     */
    public function setContexts(array $context)/*# : LogEntryInterface */
    {
        $this->context = $context;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getContexts()/*# : array */
    {
        return $this->context;
    }

    /**
     * {@inheritDoc}
     */
    public function mergeContexts(array $context)
    {
        $this->context = array_replace($this->context, $context);
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function setContext(
        /*# string */ $name,
        $value
    )/*# : LogEntryInterface */ {
        $this->context[(string) $name] = $value;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getContext(/*# string */ $name)
    {
        if (is_string($name) && isset($this->context[$name])) {
            return $this->context[$name];
        }
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function setFormatted(
        /*# string */ $formatted
    )/*# : LogEntryInterface */ {
        $this->formatted = (string) $formatted;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getFormatted()
    {
        return $this->formatted;
    }

    /**
     * {@inheritDoc}
     */
    public function stopCascading(/*# bool */ $stop = true)
    {
        $this->stopped = $stop;
    }

    /**
     * Get current cascading status
     *
     * @param  void
     * @return bool
     * @access public
     * @api
     */
    public function isCascadingStopped()
    {
        return $this->stopped;
    }

    /**
     * To string.
     *
     * Check the 'formatted' context first, if not exits, call default
     * formatter
     */
    public function __toString()
    {
        // check previous formatted message
        if ($this->getFormatted() === null) {
            $formatter = new DefaultFormatter();
            $msg = call_user_func($formatter, $this);
            $this->setFormatted($msg);
        }

        return $this->getFormatted();
    }
}
