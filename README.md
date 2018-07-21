# console-wrapper

[![Build status](https://img.shields.io/travis/Hiroto-K/console-wrapper/master.svg?style=flat-square)](https://travis-ci.org/Hiroto-K/console-wrapper)
[![License](https://img.shields.io/github/license/Hiroto-K/console-wrapper.svg?style=flat-square)](https://github.com/Hiroto-K/console-wrapper/blob/master/LICENSE)

Wrapper class of symfony/console

## Install

``composer require hiroto-k/console-wrapper:^1.0``

## Examples

### Command class

```php
<?php

namespace Example\Commands;

use HirotoK\ConsoleWrapper\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class of hoge:foo command.
 */
class HogeFooCommand extends Command
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $name = 'hoge:foo';

    /**
     * Command description.
     *
     * @var string
     */
    protected $description = 'Example command class of console-wrapper';

    /**
     * Configure command.
     */
    protected function setup()
    {
        // Setup class configure.
        // This method is called before the "configure" method.
    }

    /**
     * Execute command.
     */
    protected function handle()
    {
        // Display message.
        $this->writeln('message');

        // Display message with styles.
        $this->info('info style');
        $this->comment('comment style');
        $this->question('question style');
        $this->error('error style');


        // Get all arguments.
        $allArguments = $this->arguments();

        // Get argument value.
        $firstName = $this->argument('first-name');
        $familyName = $this->argument('family-name');

        // Check argument exists?
        $hasFamilyName = $this->hasArgument('family-name');


        // Get all options.
        $allOptions = $this->options();

        // Get option value.
        $greeting = $this->option('greeting');

        // Check option exists?
        $hasGreeting = $this->hasOption('greeting');


        // Example
        if ($greeting) {
            $this->comment(
                sprintf(
                    'Hello, %s %s',
                    $firstName,
                    $familyName
                )
            );
        }
    }

    /**
     * Define command arguments.
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
     * Define command options.
     *
     * @see \Symfony\Component\Console\Command\Command::addOption
     *
     * @return array
     */
    protected function commandOptions()
    {
        return [
            // [$name, $shortcut = null, $mode = null, $description = '', $default = null]
            ['greeting', 'g', InputOption::VALUE_NONE, 'Output greeting'],
        ];
    }
}
```

### Application class

```php
<?php

namespace Example;

use HirotoK\ConsoleWrapper\Application as WrapperApplication;
use Symfony\Component\Console\Input\InputOption;

class Application extends WrapperApplication
{
    /**
     * Define global command options.
     *  
     * @return array
     */
    protected function globalOptions()
    {
        return [
            // [$name, $shortcut = null, $mode = null, $description = '', $default = null]
            ['config', 'c', InputOption::VALUE_REQUIRED, 'Set config file', "path/to/default"],
        ];
    }
}
```

### Execute file

```php
<?php

use Example\Application;
use Example\Commands\HogeFooCommand;

$application = new Application();

// Add command.
$application->add(new HogeFooCommand());

// Start application.
$application->run();
```

### Auto add commands by PSR-4

If project using PSR-4, auto load all commands by ``loadByPsr4`` method.

```php
/**
 * Auto load commands by PSR-4.
 * 
 * loadByPsr4(string $nameSpacePrefix, string $targetDir)
 */
$application->loadByPsr4("\Example\Commands", realpath(__DIR__.'/src/Commands'));
```

### Using Logger

Set logger instance in execute file. Logger class must be implement the ``\Psr\Log\LoggerInterface`` interface.

in execute file
```php
/**
 * Set logger instance to application and command class.
 */
$application->setLogger($logger);
```

in command class
```php
protected function handle()
{
    // Using logger.
    $this->logger();
}
```

#### Default logger

Logger instance not sets in application, default using ``\Psr\Log\NullLogger`` class.

```php
protected function handle()
{
    // Output Psr\Log\NullLogger
    $this->writeln(get_class($this->logger()));
}
```

#### Override default logger

Override ``Application::createDefaultLogger`` method. Return instance must be implement the ``\Psr\Log\LoggerInterface`` interface.

```php
use HirotoK\ConsoleWrapper\Application as WrapperApplication;

class Application extends WrapperApplication
{
    /**
     * Override default logger instance.
     * Return instance must be implement the \Psr\Log\LoggerInterface
     * 
     * @return \Psr\Log\LoggerInterface
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
$application->add(new HogeFooCommand());
$application->loadByPsr4("\Example\Commands", realpath(__DIR__.'/src/Commands'));
```

### Confirm question

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

### Call other commands

Call other command in command class.

```php
protected function handle()
{
    // Call "hoge:ex" command
    $this->callCommand('hoge:ex');
}
```

with parameters

```php
protected function handle()
{
    // Call "hoge:ex" command, with name parameter
    $this->callCommand('hoge:ex', ['name' => 'example']);
}
```

### Render tables

```php
protected function handle()
{
    $headers = ['name', 'location'];
    $rows = [
        ['Hoge', 'jp'],
        ['Foo', 'us'],
    ];

    $this
        ->table($headers, $rows)
        ->render();
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

```php
$this
    ->table($headers, $rows)
    ->setColumnWidth(0, 10)
    ->render();
```

## License
[MIT License](https://github.com/Hiroto-K/console-wrapper/blob/master/LICENSE "MIT License")
