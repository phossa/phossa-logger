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
 * Normally, used to process the log, add context fields to the log etc.
 * Implementation has to make '__invoke()' concrete, thus the decorator
 * instance is a callable
 *
 * @interface
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface DecoratorInterface
{
    /**
     * Make $this callable
     *
     * class implementing this interface has to define the magic method
     * __invoke(), which takes a Phossa\Logger\LogEntryInterface object as
     * parameter and also return the same LogEntryInterface object
     *
     * @param  LogEntryInterface $log the log entry
     * @return LogEntryInterface
     * @access public
     * @api
     */
    public function __invoke(LogEntryInterface $log)/*# : LogEntryInterface */;
}
