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
 * @see     \Phossa\Logger\LogEntryInterface
 * @version 1.0.1
 * @since   1.0.0 added
 * @since   1.0.1 removed stopCascading() etc.
 */
class LogEntry implements LogEntryInterface
{
    /**
     * message string
     *
     * @var    string
     * @access protected
     */
    protected $message;

    /**
     * log level
     *
     * @var    string
     * @access protected
     * @see    \Phossa\Logger\LogLevel
     */
    protected $level;

    /**
     * UTC UNIX timestamp
     *
     * @var    float
     * @access protected
     */
    protected $timestamp;

    /**
     * contexts
     *
     * @var    array
     * @access protected
     */
    protected $context;

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
        $this->message = strval($message);
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
        $this->context[strval($name)] = $value;
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
    public function __toString()
    {
        return $this->message;
    }
}
