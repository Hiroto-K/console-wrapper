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
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

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
}
