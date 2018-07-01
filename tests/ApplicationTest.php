<?php

/*
 * This file is part of console-wrapper.
 *
 * (c) Hiroto Kitazawa <hiro.yo.yo1610@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HirotoK\ConsoleWrapper\Tests;

use HirotoK\ConsoleWrapper\Application;
use HirotoK\ConsoleWrapper\Tests\Examples\ExampleCommand;
use HirotoK\ConsoleWrapper\Tests\Examples\ExampleLogger;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ApplicationTest.
 *
 * @package HirotoK\ConsoleWrapper\Tests
 */
class ApplicationTest extends TestCase
{
    public function testLoggerNotSetsReturnNullLogger()
    {
        $application = new Application();

        $this->assertInstanceOf(NullLogger::class, $application->logger());
    }

    public function testLoggerSets()
    {
        $application = new Application();

        $loggerMock = $this->createMock(\Psr\Log\LoggerInterface::class);
        $application->setLogger($loggerMock);

        $this->assertSame($loggerMock, $application->logger());
    }

    public function testLoggerSetsToCommand()
    {
        $application = new Application();
        $application->add(new ExampleCommand());

        $loggerMock = $this->createMock(\Psr\Log\LoggerInterface::class);
        $application->setLogger($loggerMock);

        $reflection = new \ReflectionClass($application);
        $property = $reflection->getParentClass()->getProperty('commands');
        $property->setAccessible(true);
        $allCommands = $property->getValue($application);
        $command = $allCommands['example:command'];

        $reflection = new \ReflectionClass($command);
        $property = $reflection->getProperty('logger');
        $property->setAccessible(true);
        $commandLogger = $property->getValue($command);

        $this->assertSame($loggerMock, $commandLogger);
    }

    public function testDefaultLogger()
    {
        $application = new class() extends Application {
            protected function createDefaultLogger()
            {
                return new ExampleLogger();
            }
        };

        $this->assertInstanceOf(ExampleLogger::class, $application->logger());
    }

    public function testGlobalOptions()
    {
        $application = new class() extends Application {
            protected function globalOptions()
            {
                return [
                    ['config', 'c', InputOption::VALUE_REQUIRED, 'Set config file', 'path/to/default'],
                ];
            }
        };

        $definition = $application->getDefinition();
        $this->assertArrayHasKey('config', $definition->getOptions());
    }
}
