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
 * Abstract decorator
 *
 * @abstract
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Decorator\DecoratorTrait
 * @see     \Phossa\Logger\Decorator\DecoratorInterface
 * @version 1.0.4
 * @since   1.0.0 added
 */
abstract class DecoratorAbstract implements DecoratorInterface
{
    use DecoratorTrait;
}
