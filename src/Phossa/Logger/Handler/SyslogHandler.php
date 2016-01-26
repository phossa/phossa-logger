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

use Phossa\Logger\LogLevel;
use Phossa\Logger\Exception;
use Phossa\Logger\Message\Message;
use Phossa\Logger\LogEntryInterface;

/**
 * SyslogHandler
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Handler\HandlerAbstract
 * @version 1.0.0
 * @since   1.0.0 added
 */
class SyslogHandler extends HandlerAbstract
{
    /**
     * syslog ident string
     *
     * @var    string
     * @access protected
     */
    protected $ident;

    /**
     * syslog facility
     *
     * @var    int
     * @access protected
     */
    protected $facility;

    /**
     * syslog options
     *
     * @var    int
     * @access protected
     */
    protected $options;

    /**
     * log level to syslog priority map
     *
     * @var    array
     * @access protected
     */
    protected $map = [
        LogLevel::DEBUG     => LOG_DEBUG,
        LogLevel::INFO      => LOG_INFO,
        LogLevel::NOTICE    => LOG_NOTICE,
        LogLevel::WARNING   => LOG_WARNING,
        LogLevel::ERROR     => LOG_ERR,
        LogLevel::CRITICAL  => LOG_CRIT,
        LogLevel::ALERT     => LOG_ALERT,
        LogLevel::EMERGENCY => LOG_EMERG,
    ];

    /**
     * Constructor
     *
     * @param  string $ident identification string
     * @param  string $level (optional) level string
     * @param  array $configs (optional) properties to set
     * @see    openlog()
     * @see    syslog()
     * @throws Exception\InvalidArgumentException
     *         if $level not right
     * @access public
     * @api
     */
    public function __construct(
        /*# string */ $ident = 'phossa-log',
        /*# string */ $level = LogLevel::NOTICE,
        array $configs = []
    ) {
        // level
        $this->setHandleLevel($level);

        // syslog ident
        $this->ident = $ident;

        // set other properties
        $this->setProperties(
            array_replace([
                'facility'  => LOG_USER,
                'options'   => LOG_PID
            ], $configs)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(LogEntryInterface $log)
    {
        // open syslog
        if (!openlog($this->ident, $this->options, $this->facility)) {
            throw new Exception\InvalidArgumentException(
                Message::get(
                    Message::INVALID_LOG_SYSLOG,
                    $this->ident,
                    $this->facility
                ),
                Message::INVALID_LOG_SYSLOG
            );
        }

        // write syslog
        syslog(
            // syslog priority
            $this->map[$log->getLevel()],
            // formatted message
            call_user_func($this->getFormatter(), $log)
        );

        // close syslog
        closelog();
    }
}
