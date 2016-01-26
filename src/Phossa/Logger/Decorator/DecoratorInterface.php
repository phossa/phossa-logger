<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Logger\Decorator;

use Phossa\Logger\LogEntryInterface;

/**
 * Log decorator
 *
 * Normally, a decorator is used to process the log, add context fields to the
 * log etc. Implementation has to make '__invoke()' concrete, thus the
 * decorator instance is a callable
 *
 * @interface
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.1
 * @since   1.0.0 added
 * @since   1.0.1 __invoke() returns void now
 */
interface DecoratorInterface
{
    /**
     * Stop this decorator, bypass this decorator
     *
     * @param  bool $stop stop or not
     * @return void
     * @access public
     * @api
     */
    public function stopDecorator(/*# bool */ $stop = true);

    /**
     * Is this decorator stopped
     *
     * @param  void
     * @return bool
     * @access public
     * @api
     */
    public function isDecoratorStopped()/*# : bool */;

    /**
     * Make $this callable
     *
     * class implementing this interface has to define the magic method
     * __invoke(), which takes a Phossa\Logger\LogEntryInterface object as
     * parameter.
     *
     * @param  LogEntryInterface $log the log entry
     * @return void
     * @access public
     * @api
     */
    public function __invoke(LogEntryInterface $log);
}
