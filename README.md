# console-wrapper

[![Build Status](https://travis-ci.org/hiroto-k/console-wrapper.svg?branch=master)](https://travis-ci.org/hiroto-k/console-wrapper)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/hiroto-k/console-wrapper.svg)](https://packagist.org/packages/hiroto-k/console-wrapper)
[![Coverage Status](https://coveralls.io/repos/github/hiroto-k/console-wrapper/badge.svg?branch=master)](https://coveralls.io/github/hiroto-k/console-wrapper?branch=master)
[![Maintainability](https://api.codeclimate.com/v1/badges/ba59e655bdc9c4410966/maintainability)](https://codeclimate.com/github/hiroto-k/console-wrapper/maintainability)
[![License](https://img.shields.io/github/license/hiroto-k/console-wrapper.svg)](https://github.com/hiroto-k/console-wrapper/blob/master/LICENSE)

Wrapper class of [symfony/console](https://github.com/symfony/console)

## Install

``composer require hiroto-k/console-wrapper:^1.0``

## Documents

- [Examples](#examples)
    - [Command class](#example-command-class)
    - [Application class](#example-application-class)
    - [Execute file](#example-execute-file)
- [Uses](#uses)
    - [Arguments](#arguments)
        - [Definition the arguments](#definition-the-arguments)
        - [Access to arguments](#access-to-arguments)
    - [Options](#options)
        - [Definition the options](#definition-the-options)
        - [Access to options](#access-to-options)
        - [Definition the global options](#definition-the-global-options)
    - [Output](#output)
    - [Auto add commands by PSR-4](#auto-add-commands-by-psr-4)
    - [Logger](#logger)
        - [Using Logger](#using-logger)
        - [Default logger](#default-logger)
        - [Override the default logger](#override-the-default-logger)
        - [Using logger in Command::setup](#using-logger-in-commandsetup)
    - [Helpers and Utils](#helpers-and-utils)
        - [Confirm question](#confirm-question)
        - [Call other command](#call-other-command)
        - [Render tables](#render-tables)

## Examples

### Example Command class

```php
<?php

namespace ExampleApp\Commands;

use HirotoK\ConsoleWrapper\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Command class of "greeting" command.
 */
class GreetingCommand extends Command
{
    /**
     * Definition the command name.
     *
     * @var string
     */
    protected $name = 'greeting';

    /**
     * Definition the command description.
     *
     * @var string
     */
    protected $description = 'Example greeting command with console-wrapper';

    /**
     * Setup the command class.
     */
    protected function setup()
    {
        // Setup class configure.
        // This method is called before the "configure" method.
    }

    /**
     * Execute the command.
     */
    protected function handle()
    {
        $greet = $this->option('hi') ? 'Hi, ' : 'Hello, ';

        $name = $this->argument('first-name');

        if ($this->hasArgument('family-name')) {
            $name .= ' '.$this->argument('family-name');
        }

        $this->writeln($greet.$name);
    }

    /**
     * Definition the command arguments.
     *
     * @see \Symfony\Component\Console\Command\Command::addArgument
     *
     * @return array
     */
    protected function commandArguments()
    {
        return [
            // [$name, $mode = null, $description = '', $default = null]
            ['first-name', InputArgument::REQUIRED, 'Your first name (required)'],
            ['family-name', InputArgument::OPTIONAL, 'Your family name (optional)'],
        ];
    }

    /**
     * Definition the command options.
     *
     * @see \Symfony\Component\Console\Command\Command::addOption
     *
     * @return array
     */
    protected function commandOptions()
    {
        return [
            // [$name, $shortcut = null, $mode = null, $description = '', $default = null]
            ['hi', null, InputOption::VALUE_NONE, 'Use "Hi".'],
        ];
    }
}
```

### Example Application class

```php
<?php

namespace ExampleApp;

use HirotoK\ConsoleWrapper\Application as WrapperApplication;
use Symfony\Component\Console\Input\InputOption;

/**
 * Customize application class.
 */
class Application extends WrapperApplication
{
    /**
     * Definition the global command options.
     *
     * @return array
     */
    protected function globalOptions()
    {
        return [
            // [$name, $shortcut = null, $mode = null, $description = '', $default = null]
            ['debug', null, InputOption::VALUE_NONE, 'Enable debug mode.'],
            ['config', 'c', InputOption::VALUE_REQUIRED, 'Set path of config file.', 'path/to/default'],
        ];
    }
}
```

### Example execute file

```php
<?php

use ExampleApp\Application;
use ExampleApp\Commands\GreetingCommand;

$application = new Application();

// Add command class.
$application->add(new GreetingCommand());

// Start the application.
$application->run();
```

## Uses

### Arguments

#### Definition the arguments

Definition the arguments, use the ``Command::commandArguments()`` method.

Returned array will pass to the ``Command::addArgument()`` method.
See the documents for arguments of ``Command::addArgument()`` method.

- [Using Command Arguments](https://symfony.com/doc/current/console/input.html#using-command-arguments)

```php
/**
 * Definition the command arguments.
 *
 * @return array
 */
protected function commandArguments()
{
    return [
        // [$name, $mode = null, $description = '', $default = null]
        ['user-id', InputArgument::REQUIRED, 'User name (required)'],
        ['task', InputArgument::OPTIONAL, 'Task name (optional)', 'default'],
    ];
}
```

#### Access to arguments

console-wrapper is provided some proxy methods.

```php
protected function handle()
{
    // Get all arguments.
    $allArguments = $this->arguments();

    // Get argument value.
    $userId = $this->argument('user-id');

    // Check argument exists?
    $hasTaskArgument = $this->hasArgument('task');
}
```

### Options

#### Definition the options

Definition the options, use the ``Command::commandOptions()`` method.

Returned array will pass to the ``Command::addOption()`` method.
See the documents for arguments of ``Command::addOption()`` method.

- [Using Command Options](https://symfony.com/doc/current/console/input.html#using-command-options)

```php
/**
 * Definition the command options.
 *
 * @return array
 */
protected function commandOptions()
{
    return [
        // [$name, $shortcut = null, $mode = null, $description = '', $default = null]
        ['name', null, InputOption::VALUE_REQUIRED, 'User name.', 'default name'],
        ['force', null, InputOption::VALUE_NONE, 'Force execute.'],
    ];
}
```

#### Access to options

console-wrapper is provided some proxy methods.

```php
protected function handle()
{
    // Get all options.
    $allOptions = $this->options();

    // Get option value.
    $name = $this->option('name');

    // Check option exists?
    $hasForceOption = $this->hasOption('force');
}
```

#### Definition the global options

console-wrapper can easily set global options.

```php
<?php

namespace ExampleApp;

use HirotoK\ConsoleWrapper\Application as WrapperApplication;
use Symfony\Component\Console\Input\InputOption;

class Application extends WrapperApplication
{
    /**
     * Definition the global command options.
     *
     * @return array
     */
    protected function globalOptions()
    {
        return [
            // [$name, $shortcut = null, $mode = null, $description = '', $default = null]
            ['debug', null, InputOption::VALUE_NONE, 'Enable debug mode.'],
            ['config', 'c', InputOption::VALUE_REQUIRED, 'Set path of config file.', 'path/to/default'],
        ];
    }
}
```

### Output

console-wrapper is provided some output methods.

```php
protected function handle()
{
    // Display normal message.
    $this->writeln('message');
    $this->writeln([
        'multi',
        'line',
        'message',
    ]);

    // Display message with styles.
    $this->info('info style');
    $this->comment('comment style');
    $this->question('question style');
    $this->error('error style');
}
```

### Auto add commands by PSR-4

If project using PSR-4, auto load all commands by ``loadByPsr4`` method.

```php
/**
 * Auto add commands by PSR-4.
 * 
 * loadByPsr4(string $nameSpacePrefix, string $targetDir)
 */
$application->loadByPsr4("\ExampleApp\Commands", realpath(__DIR__.'/src/Commands'));
```

### Logger

#### Using Logger

Using the Logger in command class.

Logger class must be implement the ``\Psr\Log\LoggerInterface`` interface.

in execute file.

```php
/**
 * Set logger instance to application and command class.
 */
$application->setLogger($logger);
```

in command class.

```php
protected function handle()
{
    // Using logger.
    $this->logger()->debug('Debug message');
    $this->logger()->error('Error message');
}
```

#### Default logger

If logger instance not sets in application, default using ``\Psr\Log\NullLogger`` class.

[\Psr\Log\NullLogger](https://github.com/php-fig/log/blob/master/Psr/Log/NullLogger.php)

```php
protected function handle()
{
    // Output Psr\Log\NullLogger
    $this->writeln(get_class($this->logger()));
}
```

#### Override the default logger

If you want override the default logger, please override the ``Application::createDefaultLogger`` method.
Return instance must be implement the ``\Psr\Log\LoggerInterface`` interface.

```php
// Use monolog in default logger

use HirotoK\ConsoleWrapper\Application as WrapperApplication;
use Monolog\Logger;

class Application extends WrapperApplication
{
    /**
     * Override default logger instance.
     * Return instance must be implement the \Psr\Log\LoggerInterface
     * 
     * @return \Monolog\Logger
     */
    protected function createDefaultLogger()
    {
        return new Logger();
    }
}
```

#### Using logger in Command::setup

If using logger instance in ``Command::setup()`` method, **must be sets the logger instance before commands add**.

```php
// Register logger instance
$application->setLogger($logger);

// Add commands
$application->add(new GreetingCommand());
$application->loadByPsr4("\ExampleApp\Commands", realpath(__DIR__.'/src/Commands'));
```

### Helpers and Utils

#### Confirm question

Simple confirmation. Default returns ``true``.

```php
protected function handle()
{
    if ($this->confirm('continue ? (y/n) ')) {
        // If enter y
    }
}
```

sets default value

```php
protected function handle()
{
    if ($this->confirm('continue ? (y/n) ', false)) {
        // If enter y
    }
}
```

#### Call other command

Call other command in command class.

```php
protected function handle()
{
    // Call the "other-command-name" command
    $this->callCommand('other-command-name');
}
```

with parameters

```php
protected function handle()
{
    // Call the "other-command-name" command, with name parameter
    $this->callCommand('other-command-name', ['name' => 'example']);
}
```

#### Render tables

```php
protected function handle()
{
    // Only creates Table class instance.
    $table = $this->table();

    // Sets headers and rows
    $headers = ['name', 'location'];
    $rows = [
        ['Hoge', 'jp'],
        ['Foo', 'us'],
    ];
    $table = $this->table($headers, $rows)

    // Render table
    $table->render();
}
```


```text
+------+----------+
| name | location |
+------+----------+
| Hoge | jp       |
| Foo  | us       |
+------+----------+
```

customize tables, place see the ``\Symfony\Component\Console\Helper\Table`` class.

- [Document of Table class](http://symfony.com/doc/current/components/console/helpers/table.html)

```php
// Set the column width.
$this
    ->table($headers, $rows)
    ->setColumnWidth(0, 10)
    ->render();
```

## License

[MIT License](https://github.com/hiroto-k/console-wrapper/blob/master/LICENSE "MIT License")
