# Introduction

Phossa-logger is a PSR-3 compliant logging package. It is a rewrite of Monolog
with some changes.

More information about [PSR-3](http://www.php-fig.org/psr/psr-3/)

# Installation

Install via the `composer` utility.

```
composer require "phossa/phossa-logger=1.*"
```

# Usage

- The simplest usage

    ```php
    // create the logger with id 'mylogger'
    $logger = new \Phossa\Logger\Logger('mylogger');

    // logger will set default syslog and interpolate decorator
    $logger->notice('a notice from {whom}', array('whom' => $cache));
    ```

# Features

- Decorator: decorate log entry in some way

- Created `LogEntryInterface` for log entry (or call it message). It is now
  possible to extend `LogEntry` and use a factory closure to create log entry.

- Handler: distribute log entry to different devices

- Formatter: turn log entry object into string

- Handler/Decorator/Formatter all enforce '__invoke()' in the their interface,
  which makes them 'callable'. Thus, user may use all sorts of callable as
  handler, decorator or formatter.

- Support PHP 5.4+

- PHP7 ready for return type declarations and argument type declarations.

# Version

1.0.1

# Dependencies

PHP >= 5.4.0
phossa/phossa-shared >= 1.0.3
psr/log

# License

[MIT License](http://spdx.org/licenses/MIT)
