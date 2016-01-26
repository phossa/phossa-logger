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
 * Abstract decorator
 *
 * @abstract
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Decorator\DecoratorTrait
 * @see     \Phossa\Logger\Decorator\DecoratorInterface
 * @version 1.0.0
 * @since   1.0.0 added
 */
abstract class DecoratorAbstract implements DecoratorInterface
{
    use \Phossa\Logger\Decorator\DecoratorTrait;
}
