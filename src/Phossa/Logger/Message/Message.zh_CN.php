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

use Phossa\Logger\Message\Message;

/**
 * Chinese zh_CN translation for Phossa\Logger\Message\Message
 *
 * @package Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Phossa\Logger\Message\Message
 * @version 1.0.4
 * @since   1.0.4 added
 */
return [
    Message::INVALID_LOG_LEVEL     => '未知的日志警戒名 "%s"',
    Message::INVALID_LOG_HANDLER   => '"%s" 不是有效的日志处理程序',
    Message::INVALID_LOG_DECORATOR => '"%s" 不是有效的日志修正程序',
    Message::INVALID_LOG_SYSLOG    => '未知的系统日志标识 "%s" 和渠道 "%s"',
    Message::INVALID_LOG_STREAM    => '非法的流设备 "%s"',
];
