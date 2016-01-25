<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Logger\Exception;

/**
 * InvalidArgumentException for \Phossa\Logger
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @see     \Psr\Log\InvalidArgumentException
 * @version 1.0.0
 * @since   1.0.0 added
 */
class InvalidArgumentException
    extends \Psr\Log\InvalidArgumentException
    implements ExceptionInterface
{

}
