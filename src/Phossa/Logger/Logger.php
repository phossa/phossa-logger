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
use Psr\Log\LoggerInterface;
use Phossa\Logger\Message\Message;

/**
 * Logger
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Logger extends AbstractLogger implements LoggerInterface
{
    /**
     * log entry decorators
     *
     * @var    callable[]
     * @type   callable[]
     * @access protected
     */
    protected $decorators;

    /**
     * log entry handlers
     *
     * @var    callable[]
     * @type   callable[]
     * @access protected
     */
    protected $handlers;

    /**
     * Log entry factory
     *
     * @var    callable
     * @type   callable
     * @access protected
     */
    protected $factory;

    /**
     * Minimum level code
     *
     * @var    int
     * @type   int
     * @access protected
     */
    protected $level_code = 0;

    /**
     * constructor
     *
     * @param  array $handlers (optional) callable handler array
     * @param  array $decorators (optional) callable decorator array
     * @param  callable $factory (optional) log factory callable
     * @throws Exception\InvalidArgumentException
     * @access public
     */
    public function __construct(
        array $handlers   = [],
        array $decorators = [],
        callable $factory = null
    ) {
        // add handlers
        if ($handlers) $this->setHandlers($handlers);

        // add decorators
        if ($decorators) $this->setDecorators($decorators);

        // log entry factory if any
        if ($factory) $this->factory = $factory;
    }

    /**
     * Set logEntry handlers
     *
     * Handler can be instance of Handler\HandlerInterface or callable. If
     * empty, set the default handler to Handler\StreamHandler
     *
     * @param  callable[] $handlers handle array
     * @return void
     * @throws Exception\InvalidArgumentException
     *         if not the valid handler
     * @access public
     * @api
     */
    public function setHandlers(array $handlers)
    {
        // default handler
        if (empty($handlers)) {
            $handlers = [
                new Handler\StreamHandler('php://stderr', LogLevel::DEBUG)
            ];
        }

        // check handlers
        foreach($handlers as $handler) {

            // is callable
            if (!is_callable($handler)) {
                throw new Exception\InvalidArgumentException(
                    Message::get(
                        Message::WRONG_LOG_HANDLER,
                        is_object($handler) ?
                            get_class($handler) :
                            (string) $handler
                    ),
                    Message::WRONG_LOG_HANDLER
                );
            }

            // update minimum level
            if ($handler instanceof Handler\HandlerInterface) {
                $c = (int) $handler->isHandling();
                if ($c > $this->level_code) $this->level_code = $c;
            }
        }

        $this->handlers = $handlers;
    }

    /**
     * Get logEntry handlers
     *
     * @param  void
     * @return callable[]
     * @access public
     * @api
     */
    public function getHandlers()/*# : array */
    {
        if ($this->handlers) return $this->handlers;
        return [];
    }

    /**
     * Set logEntry decorators
     *
     * If empty, set the default decorator to Decorator\InterpolateDecorator
     *
     * @param  callable[] $decorators decorator array
     * @return void
     * @throws Exception\InvalidArgumentException if not valid decorator
     * @access public
     * @api
     */
    public function setDecorators(array $decorators)
    {
        // default decorator
        if (empty($decorators)) {
            $decorators = [
                new Decorator\InterpolateDecorator()
            ];
        }

        // check decorators
        foreach($decorators as $deco) {
            if (!is_callable($deco)) {
                throw new Exception\InvalidArgumentException(
                    Message::get(
                        Message::WRONG_LOG_DECORATOR,
                        is_object($deco) ?
                            get_class($deco) :
                            gettype($deco)
                    ),
                    Message::WRONG_LOG_DECORATOR
                );
            }
        }

        $this->decorators = $decorators;
    }

    /**
     * Get logEntry decorators
     *
     * @param  void
     * @return callable[]
     * @access public
     * @api
     */
    public function getDecorators()/*# : array */
    {
        if ($this->decorators) return $this->decorators;
        return [];
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
        $code = LogLevel::getLevelCode($level, true);
        if ($code < $this->level_code) return;

        // create logEntry
        if ($this->factory) {
            $log = call_user_func(
                $this->factory, $level, (string) $message, $context);
        } else {
            $log = new LogEntry($level, (string) $message, $context);
        }

        // loop thru decorators
        foreach ($this->decorators as $deco) {
            $log = call_user_func($deco, $log);
        }

        // loop thru handlers
        foreach($this->handlers as $handler) {
            $log = call_user_func($handler, $log);
            if ($log->isCascadingStopped()) break;
        }
    }
}
