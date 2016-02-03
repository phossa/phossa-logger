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

namespace Phossa\Logger\Decorator;

use Phossa\Logger\LogEntryInterface;

/**
 * Log decorator
 *
 * Normally, a decorator is used to process the log entry, add context fields
 * to the log entry. Implementation has to make '__invoke()' concrete, thus
 * the decorator instance is a callable
 *
 * @interface
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.4
 * @since   1.0.0 added
 * @since   1.0.1 __invoke() returns void now
 * @since   1.0.2 added stopDecorator()/isDecoratorStopped()
 * @since   1.0.4 added startDecorator()
 */
interface DecoratorInterface
{
    /**
     * Stop this decorator, bypass this decorator
     *
     * @return void
     * @access public
     * @api
     */
    public function stopDecorator();

    /**
     * Start or enable this decorator
     *
     * @return void
     * @access public
     * @api
     */
    public function startDecorator();

    /**
     * Is this decorator stopped
     *
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
