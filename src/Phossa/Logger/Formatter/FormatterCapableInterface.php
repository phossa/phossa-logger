<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Logger\Formatter;

/**
 * FormatterCapableInterface
 *
 * @interface
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface FormatterCapableInterface
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
     * @param  void
     * @return callable
     * @access public
     * @api
     */
    public function getFormatter()/*# : callable */;
}
