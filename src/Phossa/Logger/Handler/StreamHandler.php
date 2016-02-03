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

namespace Phossa\Logger\Handler;

use Phossa\Logger\LogLevel;
use Phossa\Logger\Exception;
use Phossa\Logger\Message\Message;
use Phossa\Logger\LogEntryInterface;

/**
 * StreamHandler
 *
 * Send log to stream
 *
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Handler\HandlerAbstract
 * @version 1.0.4
 * @since   1.0.1 added
 * @since   1.0.4 added closeStream(), $this->eol
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

        // auto-close stream ?
        $close = false;

        // file
        if (is_string($stream)) {
            $strm = null;

            // file:// prefix ?
            if ('file://' === substr($stream, 0, 7)) {
                $stream  = substr($stream, 7);
                $dirname = dirname($stream);
                $fileok  = true;
                if ($dirname && !is_dir($dirname)) {
                    $fileok = @mkdir($dirname, 0777, true);
                }
                if ($fileok) {
                    $strm  = @fopen($stream, 'a');
                    $close = true;
                }

            // php::// etc.
            } elseif (strpos($stream, '://') !== false) {
                $strm  = @fopen($stream, 'a');
                $close = true;
            }
            if (is_resource($strm)) {
                $stream = $strm;
            }
        }

        if (is_resource($stream)) {
            $this->stream = $stream;
            if ($close) {
                register_shutdown_function([__CLASS__, 'closeStream']);
            }
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
        flock($this->stream, LOCK_EX);

        // write to stream
        fwrite(
            $this->stream,
            call_user_func($this->getFormatter(), $log) . $this->eol
        );

        // release lock
        flock($this->stream, LOCK_UN);
    }

    /**
     * Close the stream on exit
     *
     * @return bool
     * @access public
     * @api
     */
    public function closeStream()
    {
        if (!is_resource($this->stream) || @fclose($this->stream)) {
            return true;
        }
        return false;
    }
}
