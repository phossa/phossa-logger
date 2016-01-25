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

use Psr\Log\AbstractLogger;
use Phossa\Logger\Message\Message;

/**
 * Logger
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Psr\Log\AbstractLogger
 * @see     \Phossa\Logger\LoggerInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Logger extends AbstractLogger implements LoggerInterface
{
    /**
     * log entry decorators
     *
     * @var    callable[]
     * @access protected
     */
    protected $decorators = [];

    /**
     * log entry handlers
     *
     * @var    callable[]
     * @access protected
     */
    protected $handlers   = [];

    /**
     * Log entry factory
     *
     * @var    callable
     * @access protected
     */
    protected $factory;

    /**
     * Minimum level code
     *
     * @var    int
     * @access protected
     */
    protected $level_code = 0;

    /**
     * identification string
     *
     * @var    string
     * @access protected
     */
    protected $ident;

    /**
     * constructor
     *
     * @param  string $ident the logger identification string
     * @param  callable[] $handlers (optional) callable handler array
     * @param  callable[] $decorators (optional) callable decorator array
     * @param  callable $factory (optional) log factory callable
     * @throws Exception\InvalidArgumentException
     * @access public
     */
    public function __construct(
        /*# string */ $ident,
        array $handlers   = [],
        array $decorators = [],
        callable $factory = null
    ) {
        // set id
        $this->ident = $ident;

        // set decorators
        $this->setDecorators($decorators);

        // set handlers
        $this->setHandlers($handlers);

        // log entry factory if any
        if ($factory) $this->factory = $factory;
    }

    /**
     * {@inheritDoc}
     */
    public function setHandlers(
        array $handlers,
        /*# bool */ $flush = true
    ) {
        // flush handlers first
        if ($flush) $this->handlers = [];

        // add handlers one by one
        if ($handlers) {
            foreach($handlers as $handler) {
                // is callable
                if (!is_callable($handler)) {
                    throw new Exception\InvalidArgumentException(
                        Message::get(
                            Message::INVALID_LOG_HANDLER,
                            is_object($handler) ?
                                get_class($handler) :
                                (string) $handler
                        ),
                        Message::INVALID_LOG_HANDLER
                    );
                }

                // add handler
                $this->addHandler($handler);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function addHandler(callable $handler)
    {
        if ($handler instanceof Handler\HandlerInterface) {
            $c = $handler->getHandleLevelCode();
            if ($c > $this->level_code) $this->level_code = $c;
        }
        $this->handlers[] = $handler;
    }

    /**
     * {@inheritDoc}
     */
    public function getHandlers()/*# : array */
    {
        return $this->handlers;
    }

    /**
     * {@inheritDoc}
     */
    public function setDecorators(
        array $decorators,
        /*# bool */ $flush = true
    ) {
        // flush decorators first
        if ($flush) $this->decorators = [];

        // add decorators one by one
        if ($decorators) {
            foreach($decorators as $deco) {
                if (!is_callable($deco)) {
                    throw new Exception\InvalidArgumentException(
                        Message::get(
                            Message::INVALID_LOG_DECORATOR,
                            is_object($deco) ?
                                get_class($deco) :
                                gettype($deco)
                        ),
                        Message::INVALID_LOG_DECORATOR
                    );
                }
                $this->addDecorator($deco);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function addDecorator(callable $decorator)
    {
        $this->decorators[] = $decorator;
    }

    /**
     * {@inheritDoc}
     */
    public function getDecorators()/*# : array */
    {
        return $this->decorators;
    }

    /**
     * {@inheritDoc}
     *
     * @throws Exception\InvalidArgumentException
     *         if $level not a recognized level
     */
    public function log($level, $message, array $context = array())
    {
        // check minimum level, Exception expected
        $code = LogLevel::getLevelCode($level);
        if ($code < $this->level_code) return;

        // create logEntry
        if ($this->factory) {
            $log = call_user_func(
                $this->factory, $level, (string) $message, $context);
        } else {
            $log = new LogEntry($level, (string) $message, $context);
        }

        // set default decorator if empty
        if (empty($this->decorators)) {
            $this->addDecorator(new Decorator\InterpolateDecorator());
        }

        // loop thru decorators
        foreach ($this->decorators as $deco) {
            $log = call_user_func($deco, $log);
        }

        // set default syslog if empty
        if (empty($this->handlers)) {
            $this->addHandler(new Handler\SyslogHandler(
                LogLevel::NOTICE,
                $this->ident
            ));
        }

        // loop thru handlers
        foreach($this->handlers as $handler) {
            $log = call_user_func($handler, $log);
            if ($log->isCascadingStopped()) break;
        }
    }
}
