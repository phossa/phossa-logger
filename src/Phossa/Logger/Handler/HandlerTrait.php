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

/**
 * Simple implementation of HandlerInterface
 *
 * @trait
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Handler\HandlerInterface
 * @version 1.0.4
 * @since   1.0.0 added
 * @since   1.0.4 added startHandler()/startBubbling(), $eol property
 */
trait HandlerTrait
{
    /**
     * print PHP_EOL or not
     *
     * @var    string
     * @access protected
     */
    protected $eol = PHP_EOL;

    /**
     * level code to handle
     *
     * @var    int
     * @access protected
     */
    protected $level_code = 0;

    /**
     * handler stopped or not
     *
     * @var    bool
     * @access protected
     */
    protected $stopped    = false;

    /**
     * bubbling up or not
     *
     * @var    bool
     * @access protected
     */
    protected $bubbling   = true;

    /**
     * {@inheritDoc}
     */
    public function isHandling(/*# string */ $level)/*# : bool */
    {
        return LogLevel::getLevelCode($level) < $this->level_code ?
            false : true;
    }

    /**
     * {@inheritDoc}
     */
    public function setHandleLevel(/*# string */ $level)
    {
        $this->level_code = LogLevel::getLevelCode($level);
    }

    /**
     * {@inheritDoc}
     */
    public function getHandleLevelCode()/*# : int */
    {
        return $this->level_code;
    }

    /**
     * {@inheritDoc}
     */
    public function stopHandler()
    {
        $this->stopped = true;
    }

    /**
     * {@inheritDoc}
     */
    public function startHandler()
    {
        $this->stopped = false;
    }

    /**
     * {@inheritDoc}
     */
    public function isHandlerStopped()/*# : bool */
    {
        return $this->stopped;
    }

    /**
     * {@inheritDoc}
     */
    public function stopBubbling()
    {
        $this->bubbling = false;
    }

    /**
     * {@inheritDoc}
     */
    public function startBubbling()
    {
        $this->bubbling = true;
    }

    /**
     * {@inheritDoc}
     */
    public function isBubblingStopped()/*# : bool */
    {
        return !$this->bubbling;
    }
}
