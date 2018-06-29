# console-wrapper

[![Build status](https://img.shields.io/travis/Hiroto-K/console-wrapper/master.svg?style=flat-square)](https://travis-ci.org/Hiroto-K/console-wrapper)
[![License](https://img.shields.io/github/license/Hiroto-K/console-wrapper.svg?style=flat-square)](https://github.com/Hiroto-K/console-wrapper/blob/master/LICENSE)

Wrapper class of symfony/console

## Install

``composer require hiroto-k/console-wrapper:^1.0``

## Tutorial

Example command class.
```php
<?php

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
     * Set arguments.
     *
     * @see \Symfony\Component\Console\Command\Command::addArgument
     *
     * @return array[]
     */
    protected function commandArguments()
    {
        return [
            // $name, $mode = null, $description = '', $default = null
            ['first-name', InputArgument::REQUIRED, 'Your first name (required)'],
            ['family-name', InputArgument::OPTIONAL, 'Your family name (optional)'],
        ];
    }

    /**
     * Set options.
     *
     * @see \Symfony\Component\Console\Command\Command::addOption
     *
     * @return array[]
     */
    protected function commandOptions()
    {
        return [
            // $name, $shortcut = null, $mode = null, $description = '', $default = null
            ['greeting', 'g', InputOption::VALUE_NONE, 'Output greeting'],
        ];
    }
}
```

in Application
```php
<?php
use HirotoK\ConsoleWrapper\Application;

$application = new Application();
$application->add(new HogeFooCommand());
$application->run();
```

## License
[MIT License](https://github.com/Hiroto-K/console-wrapper/blob/master/LICENSE "MIT License")
