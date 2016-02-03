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

use Phossa\Logger\LogEntryInterface;

/**
 * A very simple formatter implementing FormatterInterface
 *
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Formatter\FormatterAbstract
 * @version 1.0.4
 * @since   1.0.0 added
 * @since   1.0.1 extends FormatterAbstract
 */
class DefaultFormatter extends FormatterAbstract
{
    /**
     * default format
     *
     * @var    string
     * @access protected
     */
    protected $format = '[%datetime%] %channel%.%level_name%: %message%';

    /**
     * {@inheritDoc}
     */
    public function __invoke(LogEntryInterface $log)/*# : string */
    {
        $data = [
            '%datetime%'    => date('Y-m-d H:i:s', $log->getTimestamp()),
            '%channel%'     => $log->getContext('__CHANNEL__'),
            '%level_name%'  => strtoupper($log->getLevel()),
            '%message%'     => $log->getMessage(),
            '%context%'     => $this->printContext($log->getContexts())
        ];

        return strtr($this->format, $data);
    }

    /**
     * Convert context
     *
     * @param  array $context the context
     * @return string
     * @access protected
     */
    protected function printContext(array $context)
    {
        $res = '';
        foreach ($context as $name => $val) {
            // bypass internal context
            if (substr($name, 0, 2) === '__') {
                continue;
            }

            // concat contexts
            $res .= " $name: " . strval($val);
        }
        return $res ?: '';
    }
}
