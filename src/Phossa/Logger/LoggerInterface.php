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

use Psr\Log\LoggerInterface as PsrLoggerInterface;

/**
 * LoggerInterface
 *
 * Added some public functions
 *
 * @interface
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.1
 * @since   1.0.1 added
 */
interface LoggerInterface extends PsrLoggerInterface
{
    /**
     * Set channel(id)
     *
     * @param  string $channel logger channel (id)
     * @return void
     * @access public
     * @api
     */
    public function setChannel(/*# string */ $channel);

    /**
     * Get channel (id)
     *
     * @param  void
     * @return string
     * @access public
     * @api
     */
    public function getChannel()/*# : string */;

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
     * Set handlers
     *
     * Handler can be instance of Handler\HandlerInterface or other callable.
     *
     * @param  callable[] $handlers handles array
     * @param  bool $flush (optional) empty handlers first
     * @return void
     * @throws Exception\InvalidArgumentException
     *         if not the valid handler
     * @access public
     * @api
     */
    public function setHandlers(
        array $handlers,
        /*# bool */ $flush = true
    );

    /**
     * Add a handler
     *
     * Handler can be instance of Handler\HandlerInterface or other callable.
     *
     * @param  callable $handler the handler
     * @return void
     * @throws Exception\InvalidArgumentException
     *         if not the valid handler
     * @access public
     * @api
     */
    public function addHandler(callable $handler);

    /**
     * Get handlers
     *
     * @param  void
     * @return callable[]
     * @access public
     * @api
     */
    public function getHandlers()/*# : array */;

    /**
     * Set decorators
     *
     * Decorator can be instance of Decorator\DecoratorInterface or other
     * callable.
     *
     * @param  callable[] $decorators decorators array
     * @param  bool $flush (optional) empty decorators first
     * @return void
     * @throws Exception\InvalidArgumentException if not valid decorator
     * @access public
     * @api
     */
    public function setDecorators(
        array $decorators,
        /*# bool */ $flush = true
    );

    /**
     * Add a decorator
     *
     * Decorator can be instance of Decorator\DecoratorInterface or other
     * callable.
     *
     * @param  callable $decorator the decorator
     * @return void
     * @throws Exception\InvalidArgumentException
     *         if not the valid decorator
     * @access public
     * @api
     */
    public function addDecorator(callable $decorator);

    /**
     * Get decorators
     *
     * @param  void
     * @return callable[]
     * @access public
     * @api
     */
    public function getDecorators()/*# : array */;
}
