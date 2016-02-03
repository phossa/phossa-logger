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

namespace Phossa\Logger\Formatter;

/**
 * FormatterAbstract
 *
 * @abstract
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Formatter\FormatterInterface
 * @version 1.0.4
 * @since   1.0.1 added
 */
abstract class FormatterAbstract implements FormatterInterface
{
    use \Phossa\Shared\Pattern\SetPropertiesTrait;

    /**
     * Simple constructor
     *
     * @param  array $configs (optional) formatter config array
     * @access public
     * @api
     */
    public function __construct(array $configs = [])
    {
        $this->setProperties($configs);
    }
}
