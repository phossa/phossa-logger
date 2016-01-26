<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Logger\Decorator;

/**
 * DecoratorTrait
 *
 * @trait
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
trait DecoratorTrait
{
    /**
     * decorator stopped or not
     *
     * @var    bool
     * @access protected
     */
    protected $stopped    = false;

    /**
     * {@inheritDoc}
     */
    public function stopDecorator(/*# bool */ $stop = true)
    {
        $this->stopped = $stop;
    }

    /**
     * {@inheritDoc}
     */
    public function isDecoratorStopped()/*# : bool */
    {
        return $this->stopped;
    }
}
