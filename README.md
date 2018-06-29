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
        
        
        // Using logger.
        // If logger instance not set in application, using \Psr\Log\NullLogger
        $this->logger();


        // Example
        if ($greeting) {
            $this->logger()->info("FirstName : {$firstName}");
            $this->logger()->info("FamilyName : {$familyName}");

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
     * Override default logger instance.
     * Default logger class is \Psr\Log\NullLogger
     * Return instance must be implement the \Psr\Log\LoggerInterface
     * 
     * @return \Psr\Log\LoggerInterface
     */
    protected function createDefaultLogger()
    {
        return new Logger();
    }

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

/**
 * Auto load commands by PSR-4.
 * 
 * loadByPsr4(namespace, directory)
 */
$application->loadByPsr4("\Example\Commands", realpath(__DIR__.'/src/Commands'));

/**
 * Using logger.
 * Logger instance must be implement the \Psr\Log\LoggerInterface
 * Logger instance is auto set to command classes.
 */
$application->setLogger($logger);

// Start application.
$application->run();
```

## License
[MIT License](https://github.com/Hiroto-K/console-wrapper/blob/master/LICENSE "MIT License")
