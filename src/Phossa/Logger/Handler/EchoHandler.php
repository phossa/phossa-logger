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
use Phossa\Logger\LogEntryInterface;

/**
 * EchoHandler
 *
 * Echo/Print the log message to STDOUT
 *
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Handler\HandlerAbstract
 * @version 1.0.4
 * @since   1.0.1 added
 * @since   1.0.4 added property $eol
 */
class EchoHandler extends HandlerAbstract
{
    /**
     * Constructor
     *
     * @param  string $level level string
     * @param  array $configs (optional) properties to set
     * @throws Exception\InvalidArgumentException
     *         if $level not right
     * @access public
     * @api
     */
    public function __construct(
        /*# string */ $level = LogLevel::NOTICE,
        array $configs = []
    ) {
        // level
        $this->setHandleLevel($level);

        // set other properties
        $this->setProperties($configs);
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(LogEntryInterface $log)
    {
        echo call_user_func($this->getFormatter(), $log) . $this->eol;
    }
}
