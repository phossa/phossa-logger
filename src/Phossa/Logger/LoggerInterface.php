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
     * Set logEntry handlers
     *
     * Handler can be instance of Handler\HandlerInterface or callable. If
     * empty, set the default handler to Handler\SyslogHandler
     *
     * @param  callable[] $handlers handle array
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
     * Add a logEntry handler
     *
     * Handler can be instance of Handler\HandlerInterface or callable.
     *
     * @param  callable $handler the handle
     * @return void
     * @throws Exception\InvalidArgumentException
     *         if not the valid handler
     * @access public
     * @api
     */
    public function addHandler(callable $handler);

    /**
     * Get logEntry handlers
     *
     * @param  void
     * @return callable[]
     * @access public
     * @api
     */
    public function getHandlers()/*# : array */;

    /**
     * Set logEntry decorators
     *
     * @param  callable[] $decorators decorator array
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
     * Add a logEntry decorator
     *
     * Handler can be instance of Decorator\DecoratorInterface or callable.
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
     * Get logEntry decorators
     *
     * @param  void
     * @return callable[]
     * @access public
     * @api
     */
    public function getDecorators()/*# : array */;
}
