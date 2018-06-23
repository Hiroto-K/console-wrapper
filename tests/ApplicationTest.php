<?php
namespace HirotoK\ConsoleWrapper\Tests;

use HirotoK\ConsoleWrapper\Application;
use PHPUnit\Framework\TestCase;
use Psr\Log\NullLogger;

/**
 * Class ApplicationTest
 * @package HirotoK\ConsoleWrapper\Tests
 */
class ApplicationTest extends TestCase{

    public function testLoggerNotSetsReturnNullLogger(){
        $application = new Application;

        $this->assertInstanceOf(NullLogger::class, $application->logger());
    }

    public function testLoggerSets(){
        $application = new Application;

        $loggerMock = $this->createMock(\Psr\Log\LoggerInterface::class);
        $application->setLogger($loggerMock);

        $this->assertSame($loggerMock, $application->logger());
    }

}