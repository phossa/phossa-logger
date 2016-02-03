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

use Phossa\Logger\Formatter;

/**
 * Abstract handler
 *
 * @abstract
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Handler\HandlerInterface
 * @see     \Phossa\Logger\Handler\HandlerTrait
 * @see     \Phossa\Logger\Formatter\FormatterAwareInterface
 * @see     \Phossa\Logger\Formatter\FormatterAwareTrait
 * @version 1.0.4
 * @since   1.0.0 added
 */
abstract class HandlerAbstract implements
    HandlerInterface,
    Formatter\FormatterAwareInterface
{
    use HandlerTrait,
        Formatter\FormatterAwareTrait,
        \Phossa\Shared\Pattern\SetPropertiesTrait;
}
