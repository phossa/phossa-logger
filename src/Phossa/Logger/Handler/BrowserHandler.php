<?php
/*
 * Phossa Project
 *
 * @see         http://www.phossa.com/
 * @copyright   Copyright (c) 2015 phossa.com
 * @license     http://mit-license.org/ MIT License
 */
/*# declare(strict_types=1); */

namespace Phossa\Logger\Handler;

/**
 * BrowserHandler
 *
 * Send log message to browser console. Modified from
 * \Monolog\Handler\BrowserConsoleHandler
 *
 * @package \Phossa\Logger
 * @author  Hong Zhang <phossa@126.com>
 * @version 1.0.1
 * @since   1.0.1 added
 */
class BrowserHandler extends HandlerAbstract
{
    /**
     * messages
     *
     * @static
     * @var    string[]
     * @access protected
     */
    protected static $messages = [];

    /**
     * Constructor
     *
     * @param  string $level level string
     * @param  array $configs (optional) properties to set
     * @throws \Phossa\Logger\Exception\InvalidArgumentException
     *         if $level not right
     * @access public
     * @api
     */
    public function __construct(
        /*# string */ $level,
        array $configs = []
    ) {
        // level
        $this->setHandleLevel($level);

        // set other properties
        $this->setProperties($configs);

        // flush to browser console
        if (PHP_SAPI !== 'cli') {
            register_shutdown_function([__CLASS__, 'flush']);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(
        LogEntryInterface $log
    )/*# : LogEntryInterface */ {

        // check level
        if (!$this->isHandling($log->getLevel())) return $log;

        // add messages
        static::$messages[] = call_user_func($this->getFormatter(), $log);

        // stop ?
        if ($this->stop) $log->stopCascading();

        return $log;
    }

    /**
     * flush the messages to browser
     *
     * @param  void
     * @return void
     * @access public
     * @static
     * @api
     */
    public static function flush()
    {
        // Check content type
        $html = true;
        foreach (headers_list() as $header) {
            if (stripos($header, 'content-type:') === 0) {
                if (stripos($header, 'application/javascript') !== false ||
                    stripos($header, 'text/javascript') !== false
                ) {
                    $html = false;
                } elseif (stripos($header, 'text/html') === false) {
                    return;
                }
                break;
            }
        }

        if (static::$messages) {
            if ($html) {
                echo '<script>' , static::generateScript() , '</script>';
            } else {
                echo static::generateScript();
            }
        }
        static::$messages = [];
    }

    private static function generateScript()
    {
        $script = array();
        foreach (static::$messages as $record) {
            $script[] = static::callArray('log', static::handleStyles($record));
        }
        return "(function (c) {if (c && c.groupCollapsed) {\n" .
            implode("\n", $script) . "\n}})(console);";
    }

    protected static function callArray($method, array $args)
    {
        return 'c.' . $method . '(' . implode(', ', $args) . ');';
    }

    protected static function handleStyles($formatted)
    {
        $args = array(static::quote('font-weight: normal'));
        $format = '%c' . $formatted;
        preg_match_all('/\[\[(.*?)\]\]\{([^}]*)\}/s', $format,
            $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER
        );

        foreach (array_reverse($matches) as $match) {
            $args[] = static::quote(static::handleCustomStyles(
                $match[2][0], $match[1][0])
            );
            $args[] = '"font-weight: normal"';

            $pos = $match[0][1];
            $format = substr($format, 0, $pos) . '%c' . $match[1][0] .
                '%c' . substr($format, $pos + strlen($match[0][0]));
        }

        array_unshift($args, static::quote($format));

        return $args;
    }

    protected static function handleCustomStyles($style, $string)
    {
        static $colors = array('blue', 'green', 'red', 'magenta',
            'orange', 'black', 'grey'
        );
        static $labels = array();

        return preg_replace_callback('/macro\s*:(.*?)(?:;|$)/',
            function ($m) use ($string, &$colors, &$labels) {
            if (trim($m[1]) === 'autolabel') {
                // Format the string as a label with consistent
                // auto assigned background color
                if (!isset($labels[$string])) {
                    $labels[$string] = $colors[count($labels) % count($colors)];
                }
                $color = $labels[$string];

                return "background-color: $color; color: white; border-radius: 3px; padding: 0 2px 0 2px";
            }

            return $m[1];
        }, $style );
    }

    protected static function quote($arg)
    {
        return '"' . addcslashes($arg, "\"\n\\") . '"';
    }
}
