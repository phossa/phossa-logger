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

namespace Phossa\Logger\Formatter;

/**
 * FormatterAwareInterface
 *
 * @interface
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.4
 * @since   1.0.0 added
 */
interface FormatterAwareInterface
{
    /**
     * Set formatter
     *
     * @param  callable $formatter
     * @return void
     * @access public
     * @api
     */
    public function setFormatter(callable $formatter);

    /**
     * Get formatter
     *
     * If not set, return the Phossa\Logger\Formatter\DefaultFormatter
     *
     * @return callable
     * @access public
     * @api
     */
    public function getFormatter()/*# : callable */;
}
