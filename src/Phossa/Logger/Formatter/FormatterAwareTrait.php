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
 * Simple implementation of FormatterAwareInterface
 *
 * @trait
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Formatter\FormatterAwareInterface
 * @version 1.0.4
 * @since   1.0.0 added
 */
trait FormatterAwareTrait
{
    /**
     * formatter
     *
     * @var    callable
     * @access protected
     */
    protected $formatter;

    /**
     * {@inheritDoc}
     */
    public function setFormatter(callable $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * {@inheritDoc}
     */
    public function getFormatter()/*# : callable */
    {
        if (is_null($this->formatter)) {
            $this->formatter = new DefaultFormatter();
        }
        return $this->formatter;
    }
}
