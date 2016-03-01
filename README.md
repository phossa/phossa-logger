# phossa-logger
[![Build Status](https://travis-ci.org/phossa/phossa-logger.svg?branch=master)](https://travis-ci.org/phossa/phossa-logger.svg?branch=master)
[![HHVM Status](http://hhvm.h4cc.de/badge/phossa/phossa-logger.svg)](http://hhvm.h4cc.de/package/phossa/phossa-logger)
[![Latest Stable Version](https://poser.pugx.org/phossa/phossa-logger/v/stable)](https://packagist.org/packages/phossa/phossa-logger)
[![License](https://poser.pugx.org/phossa/phossa-logger/license)](https://packagist.org/packages/phossa/phossa-logger)

Introduction
---

Phossa-logger is a PSR-3 compliant logging library. It is a rewrite of Monolog
with lots of changes.

More information about [PSR-3](http://www.php-fig.org/psr/psr-3/)

Installation
---

Install via the `composer` utility.

```
composer require "phossa/phossa-logger=1.*"
```

or add the following lines to your `composer.json`

```json
{
    "require": {
       "phossa/phossa-logger": "^1.0.5"
    }
}
```

Usage
---

- Simple usage

    ```php
    // logger with id 'mylogger'
    $logger = new \Phossa\Logger\Logger('mylogger');

    // a notice
    $logger->notice('a notice from code');

    // a warning
    $logger->warning('a warning from code');
    ```

Features
---

- Decorator: used to modify the `$logEntry` in some way.

  - Implements the `__invoke()` method, makes decorator a callable

    ```php
    class InterpolateDecorator extends DecoratorAbstract
    {
        public function __invoke(LogEntryInterface $log)
        {
            // ...
        }
    }
    ```

  - User-defined functions can also be used as decorator

    ```php
    $logger->setDecorators([
        new Decorator/InterpolateDecorator(),
        function ($logEntry) {
            // ...
        }
    ]);
    ```

  - Decorator implements `DecoratorInterface` can be disabled at runtime

    ```php
    $inter = new Decorator/InterpolateDecorator();
    $logger->addDecorator($inter);
    // ...

    // disble the InterpolateDecorator at runtime
    $inter->stopDecorator();
    ```

- Handler: distribute log entry to different devices. Multiple handlers can be
  set at the same time.

  ```php
  // create a logger with channel 'MyLogger'
  $logger  = new Logger('MyLogger');

  // syslog handler with ident set to 'MyLogger'
  $syslog  = new Handler\SyslogerHandler($logger->getChannel());

  // console handler with output to stderr
  $console = new Handler\TerminalHandler();

  // add handlers
  $logger->addHandler($syslog);
  $logger->addHandler($console);

  // ...
   // at some point, stop console logging
  $console->stopHandler();
  ```

- Formatter: turn log entry object into string. A formatter is bound to a
  specific handler.

  ```php
  // console handler with output to stderr
  $console = new Handler\TerminalHandler();

  // set AnsiFormatter
  $console->setFormatter(new Formatter\AnsiFormatter());
  ```

- Handler/Decorator/Formatter all enforce '__invoke()' in the their interface,
  which makes them callable.

- User may use all sorts of callable as handler, decorator or formatter.

  ```php
  // handler
  $syslog = new SyslogHandler();

  // set a anonymous function as a formatter
  $syslog->setFormatter(
      function ($log) {
          // ...
          return $string;
      }
  );

  // adding different handlers
  $logger->setHandlers([
      $syslog,
      function ($log) {
          // convert $log to string and send to a log device
          // ...
      }
  ]);
  ```

- `LogEntryInterface` for log entry (or call it message). It is now possible to
  extend `LogEntry` and use a factory closure to create log entry.

  ```php
  $logger = new Logger('MyLogger', [], [],
      function ($level, $message, $context) {
          return new MyLogEntry($level, $message, $context);
      }
  );
  ```

- Support PHP 5.4+, PHP 7.0+, HHVM

- PHP7 ready for return type declarations and argument type declarations.

- PSR-1, PSR-2, PSR-3, PSR-4 compliant.

Dependencies
---

- PHP >= 5.4.0
- phossa/phossa-shared >= 1.0.3
- psr/log

License
---

[MIT License](http://spdx.org/licenses/MIT)
