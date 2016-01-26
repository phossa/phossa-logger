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
 * StreamHandler
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Handler\HandlerAbstract
 * @version 1.0.1
 * @since   1.0.1 added
 */
class StreamHandler extends HandlerAbstract
{
    /**
     * stream
     *
     * @var    resource
     * @access protected
     */
    protected $stream;

    /**
     * Constructor
     *
     * @param  string|resource $stream the stream
     * @param  string $level level string
     * @param  array $configs (optional) properties to set
     * @throws Exception\InvalidArgumentException
     *         if $level not right, $stream not right
     * @access public
     * @api
     */
    public function __construct(
        $stream = 'php://stdout',
        /*# string */ $level = LogLevel::NOTICE,
        array $configs = []
    ) {
        // level
        $this->setHandleLevel($level);

        // file
        if (is_string($stream)) {
            $_stream = null;

            // file:// prefix ?
            if ('file://' === substr($stream, 0, 7)) {
                $stream = substr($stream, 7);
                $dirname = dirname($stream);
                if ($dirname && !is_dir($dirname)) @mkdir($dirname, 0777, true);
                $_stream = @fopen($stream, 'a');

            // php::// etc.
            } else if (strpos($stream, '://') !== false) {
                $_stream = @fopen($stream, 'a');
            }

            if (is_resource($_stream)) $stream = $_stream;
        }

        if (is_resource($stream)) {
            $this->stream = $stream;
        } else {
            throw new Exception\InvalidArgumentException(
                Message::get(
                    Message::INVALID_LOG_STREAM,
                    $stream
                ),
                Message::INVALID_LOG_STREAM
            );
        }

        // set other properties
        $this->setProperties($configs);
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(LogEntryInterface $log)
    {
        // lock
        flock( $this->stream, LOCK_EX);

        // write to stream
        fwrite(
            $this->stream,
            call_user_func($this->getFormatter(), $log) . PHP_EOL
        );

        // release lock
        flock( $this->stream, LOCK_UN);
    }
}
