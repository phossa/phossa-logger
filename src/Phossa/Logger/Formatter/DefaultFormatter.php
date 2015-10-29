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
 * A very simple formatter
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
class DefaultFormatter implements FormatterInterface
{
    /**
     * {@inheritDoc}
     */
    public function __invoke(LogEntryInterface $log)/*# : string */
    {
        $msg = sprintf(
            '%s [%s]: %s',
            date('Y-m-d H:i:s', $log->getTimestamp()),
            strtoupper($log->getLevel()),
            $log->getMessage()
        );
        $log->setFormatted($msg);

        return $msg;
    }
}
