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
 * Log entry class
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     Phossa\Logger\LogEntryInterface
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
     * @see    Phossa\Logger\LogLevel
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
     * @param  array $contexts (optional) message context
     * @access public
     * @throws Exception\InvalidArgumentException if invalid level given
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
        // check level
        LogLevel::getLevelCode($level);

        // set level
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
    public function stopCascading()
    {
        $this->stopped = true;
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
     */
    public function __toString()
    {
        return $this->message;
    }
}
