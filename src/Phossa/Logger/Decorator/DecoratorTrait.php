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

namespace Phossa\Logger\Decorator;

/**
 * Implemented stopDecorator() and isDecoratorStopped()
 *
 * @trait
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.4
 * @since   1.0.2 added
 * @since   1.0.4 added startDecorator()
 */
trait DecoratorTrait
{
    /**
     * decorator stopped or not
     *
     * @var    bool
     * @access protected
     */
    protected $stopped = false;

    /**
     * {@inheritDoc}
     */
    public function stopDecorator()
    {
        $this->stopped = true;
    }

    /**
     * {@inheritDoc}
     */
    public function startDecorator()
    {
        $this->stopped = false;
    }

    /**
     * {@inheritDoc}
     */
    public function isDecoratorStopped()/*# : bool */
    {
        return $this->stopped;
    }
}
