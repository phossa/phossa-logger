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

use Phossa\Logger\LogEntryInterface;

/**
 * FormatterInterface
 *
 * @interface
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
interface FormatterInterface
{
    /**
     * Format the log entry, return the formatted string
     *
     * class implementing this interface has to define the magic method
     * __invoke(), which takes a Phossa\Logger\LogEntryInterface object as
     * parameter and return the formatted string
     *
     * @param  LogEntryInterface $log the log entry
     * @return string
     * @access public
     * @api
     */
    public function __invoke(LogEntryInterface $log)/*# : string */;
}
