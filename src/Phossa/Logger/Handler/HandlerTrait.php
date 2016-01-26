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

/**
 * Simple implementation of HandlerInterface
 *
 * @trait
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Handler\HandlerInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait HandlerTrait
{
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
    public function stopHandler(/*# bool */ $stop = true)
    {
        $this->stopped = $stop;
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
    public function stopBubbling(/*# bool */ $stop = true)
    {
        $this->bubbling = !$stop;
    }

    /**
     * {@inheritDoc}
     */
    public function isBubblingStopped()/*# : bool */
    {
        return !$this->bubbling;
    }
}
