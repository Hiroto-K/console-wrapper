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

use HirotoK\ConsoleWrapper\Tests\Examples\ExampleCommand;
use PHPUnit\Framework\TestCase;

/**
 * Class CommandTest.
 *
 * @package HirotoK\ConsoleWrapper\Tests
 */
class CommandTest extends TestCase
{
    public function testName()
    {
        $command = new ExampleCommand();
        $this->assertSame('example:command', $command->getName());
    }

    public function testDescription()
    {
        $command = new ExampleCommand();

        $this->assertSame('This is a test description', $command->getDescription());
    }

    public function testHidden()
    {
        $command = new ExampleCommand();

        $this->assertTrue($command->isHidden());
    }

    public function testCommandArguments()
    {
        $command = new ExampleCommand();
        $definition = $command->getDefinition();

        $this->assertArrayHasKey('first-name', $definition->getArguments());
        $this->assertArrayHasKey('family-name', $definition->getArguments());
    }

    public function testCommandOptions()
    {
        $command = new ExampleCommand();
        $definition = $command->getDefinition();

        $this->assertArrayHasKey('greeting', $definition->getOptions());
    }

    public function testTable()
    {
        $command = new ExampleCommand();

        $reflection = new \ReflectionClass($command);
        $output = $reflection->getProperty('output');
        $output->setAccessible(true);
        $output->setValue($command, $this->createOutputMock());
        $method = $reflection->getMethod('table');
        $method->setAccessible(true);

        $this->assertInstanceOf(\Symfony\Component\Console\Helper\Table::class, $method->invoke($command));
    }

    protected function createOutputMock()
    {
        return $this->createMock(\Symfony\Component\Console\Output\OutputInterface::class);
    }
}
