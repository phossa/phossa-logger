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
use Phossa\Logger\Formatter\AnsiFormatter;

/**
 * TerminalHandler
 *
 * log to terminal or console
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Handler\StreamHandler
 * @version 1.0.1
 * @since   1.0.1 added
 */
class TerminalHandler extends StreamHandler
{
    /**
     * Use ANSI color?
     *
     * @var    bool
     * @access protected
     */
    protected $color = true;

    /**
     * Constructor
     *
     * @param  string|resource $device the terminal device
     * @param  string $level level string
     * @param  array $configs (optional) properties to set
     * @throws \Phossa\Logger\Exception\InvalidArgumentException
     *         if $level not right, $device not right
     * @access public
     * @api
     */
    public function __construct(
        /*# string */ $device = 'php://stderr',
        /*# string */ $level  = LogLevel::NOTICE,
        array $configs = []
    ) {
        // open terminal
        $stream = @fopen($device, 'a');
        if (!is_resource($stream)) {
            throw new Exception\InvalidArgumentException(
                Message::get(
                    Message::INVALID_LOG_STREAM,
                    $device
                ),
                Message::INVALID_LOG_STREAM
            );
        }

        // parent constructor
        parent::__construct($stream, $level, $configs);
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(LogEntryInterface $log)
    {
        // set ansi color formatter
        if ($this->color) {
            $ansi = new AnsiFormatter();
            if ($this->formatter) $ansi->setSlave($this->formatter);
            $this->setFormatter($ansi);
        }

        // invoke parent's __invoke
        parent::__invoke($log);
    }
}
