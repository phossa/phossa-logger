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

use Phossa\Logger\LogEntryInterface;

/**
 * Interpolate placeholders in the message according to psr-3
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
class InterpolateDecorator implements DecoratorInterface
{
    /**
     * {@inheritDoc}
     * 
     * Interpolates '{placeholder}' into text according to context array
     */
    public function __invoke(LogEntryInterface $log)/*# : LogEntryInterface */
    {
        $msg = $log->getMessage();
        if (strpos($msg, '{') === false) return $log;

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
                $xval = (string) $val;
            } else {
                $xval = 'TYPE: '.strtoupper(gettype($val));
            }
            $replace['{'.$key.'}'] = $xval;
        }

        // interpolate replacement values into the message
        return $log->setMessage(strtr($msg, $replace));
    }
}
