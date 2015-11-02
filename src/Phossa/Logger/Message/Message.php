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
     * @var   int
     * @type  int
     */

    /**
     * Invalid level name "%s" found
     */
    const INVALID_LOG_LEVEL     = 1510271320;

    /**
     * "%s" not a valid log handler
     */
    const INVALID_LOG_HANDLER   = 1510271321;

    /**
     * "%s" not a valid log decorator
     */
    const INVALID_LOG_DECORATOR = 1510271322;

    /**
     * Invalid syslog ident "%s" facility "%s"
     */
    const INVALID_LOG_SYSLOG    = 1510271323;
    
    /**#@-*/

    /**
     * {@inheritdoc}
     */
    protected static $messages = [
        self::INVALID_LOG_LEVEL     => 'Invalid level name "%s" found',
        self::INVALID_LOG_HANDLER   => '"%s" not a valid log handler',
        self::INVALID_LOG_DECORATOR => '"%s" not a valid log decorator',
        self::INVALID_LOG_SYSLOG    => 'Invalid syslog ident "%s" facility "%s"',
    ];
}
