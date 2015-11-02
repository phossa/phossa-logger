# Introduction
Phossa is a lightweight PHP framework. Phossa-logger is a rewrite of Monolog,
with some changes, specially tailored for Phossa framework.

# Features

- Created LogEntryInterface for log entry (or call it message). It is now
  possible to extend `LogEntry` and use a factory closure to create log entry.

- Handler: distribute log entry to different devices

- Decorator: decorate log entry in some way

- Formatter: turn log entry object into string

- Handler/Decorator/Formatter all enforce '__invoke()' in the their interface,
  which makes them 'callable'. Thus, user may use all sorts of callable as
  handler, decorator or formatter.

- Support PHP 5.4+

- PHP7 ready for return type declarations and argument type declarations.

# Version
1.0.0

# Dependencies
PHP >= 5.4.0
phossa-shared >= 1.0.0
