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
use HirotoK\ConsoleWrapper\Exception\LogicException;
use HirotoK\ConsoleWrapper\Tests\Examples\ExampleCommand;
use HirotoK\ConsoleWrapper\Tests\Examples\ExampleLogger;
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

    /**
     * Test setLogger
     *
     * add command => set logger
     */
    public function testSetLoggerAfterAddCommand()
    {
        $application = new Application();
        $exampleCommand = new ExampleCommand();

        $application->add($exampleCommand);

        $loggerMock = $this->createMock(\Psr\Log\LoggerInterface::class);
        $application->setLogger($loggerMock);

        $commandLogger = $this->getProperty($exampleCommand, 'logger');

        $this->assertSame($loggerMock, $commandLogger);
    }

    /**
     * Test setLogger
     *
     * set logger => add command
     */
    public function testSetLoggerBeforeAddCommand()
    {
        $application = new Application();
        $exampleCommand = new ExampleCommand();

        $loggerMock = $this->createMock(\Psr\Log\LoggerInterface::class);
        $application->setLogger($loggerMock);

        $application->add($exampleCommand);

        $commandLogger = $this->getProperty($exampleCommand, 'logger');

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

    public function testDefaultLoggerNotImplemented()
    {
        $application = new class() extends Application {
            protected function createDefaultLogger()
            {
                return new \stdClass();
            }
        };

        try {
            $application->logger();

            $this->fail('Application::logger method does not throw the LogicException.');
        } catch (\LogicException $e) {
            $this->assertInstanceOf(LogicException::class, $e);
        }
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
