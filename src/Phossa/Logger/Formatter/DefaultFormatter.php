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
 * A very simple formatter implementing FormatterInterface
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Formatter\FormatterAbstract
 * @version 1.0.0
 * @since   1.0.0 added
 * @since   1.0.1 extends FormatterAbstract
 */
class DefaultFormatter extends FormatterAbstract
{
    /**
     * default format
     *
     * @var    string
     * @access protected
     */
    protected $format = '%datetime% [%level_name%]: %message%';

    /**
     * {@inheritDoc}
     */
    public function __invoke(LogEntryInterface $log)/*# : string */
    {
        $data = [
            '%datetime%'    => date('Y-m-d H:i:s', $log->getTimestamp()),
            '%level_name%'  => strtoupper($log->getLevel()),
            '%message%'     => $log->getMessage()
        ];
        
        return strtr($this->format, $data);
    }
}
