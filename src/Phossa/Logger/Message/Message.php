<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Logger\Message;

use Phossa\Shared\Message\MessageAbstract;

/**
 * Message class for Phossa\Logger
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.0
 * @since   1.0.0 added
 */
class Message extends MessageAbstract
{
    /**#@+
     * @type  int
     */

    /**
     * Wrong log level name
     */
    const WRONG_LOG_LEVEL       = 1510271320;

    /**
     * Wrong log handler
     */
    const WRONG_LOG_HANDLER     = 1510271321;

    /**
     * Wrong log handler
     */
    const WRONG_LOG_DECORATOR   = 1510271322;

    /**#@-*/

    /**
     * {@inheritdoc}
     */
    protected static $messages = [
        self::WRONG_LOG_LEVEL       => 'Wrong level name "%s" found',
        self::WRONG_LOG_HANDLER     => '"%s" not a valid log handler',
        self::WRONG_LOG_DECORATOR   => '"%s" not a valid log decorator',
    ];
}
