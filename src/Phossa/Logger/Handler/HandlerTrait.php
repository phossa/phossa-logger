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
 * @see     Phossa\Logger\Handler\HandlerInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait HandlerTrait
{
    /**
     * level code to handle
     *
     * @var    int
     * @type   int
     * @access protected
     */
    protected $level_code = 0;

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
}
