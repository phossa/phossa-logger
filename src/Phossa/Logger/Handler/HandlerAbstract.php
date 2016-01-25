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

use Phossa\Logger\Formatter;

/**
 * Abstract handler
 *
 * @abstract
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Handler\HandlerInterface
 * @see     \Phossa\Logger\Handler\HandlerTrait
 * @see     \Phossa\Logger\Formatter\FormatterAwareInterface
 * @see     \Phossa\Logger\Formatter\FormatterAwareTrait
 * @version 1.0.0
 * @since   1.0.0 added
 */
abstract class HandlerAbstract implements
    HandlerInterface, Formatter\FormatterAwareInterface
{
    use HandlerTrait,
        Formatter\FormatterAwareTrait,
        \Phossa\Shared\Pattern\SetPropertiesTrait;

    /**
     * stop cascading
     *
     * @var    bool
     * @access protected
     */
    protected $stop = false;
}
