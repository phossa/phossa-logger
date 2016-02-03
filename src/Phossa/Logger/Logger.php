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

use Psr\Log\AbstractLogger;
use Phossa\Logger\Message\Message;

/**
 * Logger
 *
 * e.g.
 * <code>
 *     // default to syslog handler with interpolate decorator
 *     $logger = new \Phossa\Logger\Logger('mylogger');
 *
 *     // issue a notice
 *     $logger->notice('send a notice');
 * </code>
 *
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Psr\Log\AbstractLogger
 * @see     \Phossa\Logger\LoggerInterface
 * @version 1.0.4
 * @since   1.0.0 added
 * @since   1.0.1 added setChannel()/getChannel()
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
    protected $log_factory;

    /**
     * Minimum level code
     *
     * @var    int
     * @access protected
     */
    protected $level_code;

    /**
     * channel string
     *
     * @var    string
     * @access protected
     */
    protected $channel;

    /**
     * constructor
     *
     * the $logFactory signature is the same as LogEntry
     * <code>
     *     $logger = new Logger('MyLogger', [], [],
     *         function ($level, $message, $context) {
     *             return new MyLogEntry($level, $message, $context);
     *         }
     *     );
     * </code>
     *
     * @param  string $channel the logger channel/id string
     * @param  callable[] $handlers (optional) callable handler array
     * @param  callable[] $decorators (optional) callable decorator array
     * @param  callable $logFactory (optional) log factory callable
     * @return void
     * @throws Exception\InvalidArgumentException
     * @access public
     * @api
     */
    public function __construct(
        /*# string */ $channel,
        array $handlers   = [],
        array $decorators = [],
        callable $logFactory = null
    ) {
        // set channel/id
        $this->setChannel($channel);

        // set decorators
        $this->setDecorators($decorators);

        // set handlers
        $this->setHandlers($handlers);

        // set default minimum level
        $this->level_code = LogLevel::getLevelCode(LogLevel::WARNING);

        // log entry factory if any
        if ($logFactory) {
            $this->log_factory = $logFactory;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setChannel(/*# string */ $channel)
    {
        $this->channel = (string) $channel;
    }

    /**
     * {@inheritDoc}
     */
    public function getChannel()/*# : string */
    {
        return $this->channel;
    }

    /**
     * {@inheritDoc}
     */
    public function isHandling(/*# string */ $level)/*# : bool */
    {
        if (LogLevel::getLevelCode($level) < $this->level_code) {
            return false;
        }
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function setHandlers(
        array $handlers,
        /*# bool */ $flush = true
    ) {
        // flush handlers first
        if ($flush) {
            $this->handlers = [];
        }

        // add handlers one by one
        if (count($handlers)) {
            foreach ($handlers as $handler) {
                // is callable
                if (!is_callable($handler)) {
                    throw new Exception\InvalidArgumentException(
                        Message::get(
                            Message::INVALID_LOG_HANDLER,
                            is_object($handler) ?
                                get_class($handler) :
                                strval($handler)
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
            $code = $handler->getHandleLevelCode();
            if ($code < $this->level_code) {
                $this->level_code = $code;
            }
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
        if ($flush) {
            $this->decorators = [];
        }

        // add decorators one by one
        if (count($decorators)) {
            foreach ($decorators as $deco) {
                if (!is_callable($deco)) {
                    throw new Exception\InvalidArgumentException(
                        Message::get(
                            Message::INVALID_LOG_DECORATOR,
                            is_object($deco) ?
                                get_class($deco) :
                                strval($deco)
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
        // set default decorator if empty
        if (empty($this->decorators)) {
            $this->addDecorator(new Decorator\InterpolateDecorator());
        }

        // set default handler if empty
        if (empty($this->handlers)) {
            $this->addHandler(new Handler\SyslogHandler(
                $this->getChannel(),
                LogLevel::NOTICE
            ));
        }

        // handling this level ?
        if (!$this->isHandling($level)) {
            return;
        }

        // set channel context (reserved)
        $context['__CHANNEL__'] = $this->getChannel();

        // create logEntry
        if ($this->log_factory) {
            $log = call_user_func(
                $this->log_factory,
                $level,
                $message,
                $context
            );
        } else {
            $log = new LogEntry($level, $message, $context);
        }

        // loop thru decorators
        foreach ($this->decorators as $deco) {
            if (! $deco instanceof Decorator\DecoratorInterface ||
                ! $deco->isDecoratorStopped()) {
                call_user_func($deco, $log);
            }
        }

        // loop thru handlers
        foreach ($this->handlers as $handler) {
            // handler instance
            if ($handler instanceof Handler\HandlerInterface) {
                // call handler instance
                if (!$handler->isHandlerStopped() &&
                    $handler->isHandling($log->getLevel())) {
                    call_user_func($handler, $log);
                }

                // logEntry bubbling stopped ?
                if ($handler->isBubblingStopped()) {
                    break;
                }

            // other callable
            } else {
                call_user_func($handler, $log);
            }
        }
    }
}
