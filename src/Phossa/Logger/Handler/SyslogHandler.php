<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Logger\Handler;

use Phossa\Logger\LogEntryInterface;

/**
 * SyslogHandler
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
class SyslogHandler extends HandlerAbstract implements HandlerInterface
{
    /**
     * Constructor
     *
     * @param  string $level level string
     * @access public
     * @api
     */
    public function __construct(
        /*# string */ $level
    ) {
        // level
        $this->setHandleLevel($level);
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(
        LogEntryInterface $log
    )/*# : LogEntryInterface */ {

        // check level
        if ($this->isHandling($log->getLevel()) === false) return $log;

        // format message
        $msg = call_user_func($this->getFormatter(), $log);

        // write to syslog
        
        return $log;
    }
}
