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

use Phossa\Logger\LogEntryInterface;

/**
 * Interpolate placeholders in the message according to psr-3
 *
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Decorator\DecoratorTrait
 * @version 1.0.4
 * @since   1.0.0 added
 * @since   1.0.1 __invoke() returns void now, extends DecoratorAbstract
 */
class InterpolateDecorator extends DecoratorAbstract
{
    /**
     * Replace any '{item}' in the messsage with context['item'] value
     *
     * @see     http://www.php-fig.org/psr/psr-3/
     */
    public function __invoke(LogEntryInterface $log)
    {
        $msg = $log->getMessage();
        if (strpos($msg, '{') === false) {
            return;
        }

        // build a replacement array with braces around the context keys
        $replace = [];
        $context = $log->getContexts();

        foreach ($context as $key => $val) {
            if (is_object($val)) {
                if ($val instanceof \Exception) {
                    $xval = 'EXCEPTION: ' . $val->getMessage();
                } elseif (method_exists($val, '__toString')) {
                    $xval = (string) $val;
                } else {
                    $xval = 'OBJECT: '.get_class($val);
                }
            } elseif (is_scalar($val)) {
                $xval = strval($val);
            } else {
                $xval = 'TYPE: '.strtoupper(gettype($val));
            }
            $replace['{'.$key.'}'] = $xval;
        }

        // interpolate replacement values into the message
        $log->setMessage(strtr($msg, $replace));
    }
}
