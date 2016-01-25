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

use Phossa\Logger\Formatter\AnsiFormatter;

/**
 * TerminalHandler
 *
 * log to terminal or console
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
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
     * @param  string $level level string
     * @param  array $configs (optional) properties to set
     * @param  string|resource $device the terminal device
     * @throws Phossa\Logger\Exception\InvalidArgumentException
     *         if $level not right, $device not right
     * @access public
     * @api
     */
    public function __construct(
        /*# string */ $level,
        array $configs = [],
        /*# string */ $device = 'php://stderr'
    ) {
        // open terminal
        $stream = @fopen($device);
        if (is_resource($stream)) {
            // default ansi formatter
            if ($this->color) $this->setFormatter(new AnsiFormatter());
        } else {
            throw new Exception\InvalidArgumentException(
                Message::get(
                    Message::INVALID_LOG_STREAM,
                    $device
                ),
                Message::INVALID_LOG_STREAM
            );
        }

        // parent constructor
        parent::__construct($level, $stream, $configs);
    }
}
