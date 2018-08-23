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

    public function testArgument()
    {
        $command = new ExampleCommand();

        $inputMock = $this->createInputMock();
        $inputMock
            ->method('getArgument')
            ->with('hoge')
            ->willReturn('foo');
        $this->setProperty($command, 'input', $inputMock);

        $this->assertSame('foo', $this->callMethod($command, 'argument', 'hoge'));
    }

    public function testArgumentWithoutName()
    {
        $arguments = [
            'hoge' => 'piyo',
            'foo' => 'bar',
        ];

        $command = new ExampleCommand();

        $inputMock = $this->createInputMock();
        $inputMock
            ->method('getArguments')
            ->willReturn($arguments);
        $this->setProperty($command, 'input', $inputMock);

        $this->assertSame($arguments, $this->callMethod($command, 'argument'));
    }

    public function testArguments()
    {
        $arguments = [
            'hoge' => 'piyo',
            'foo' => 'bar',
        ];

        $command = new ExampleCommand();

        $inputMock = $this->createInputMock();
        $inputMock
            ->method('getArguments')
            ->willReturn($arguments);
        $this->setProperty($command, 'input', $inputMock);

        $this->assertSame($arguments, $this->callMethod($command, 'arguments'));
    }

    public function testHasArgument()
    {
        $command = new ExampleCommand();

        $inputMock = $this->createInputMock();
        $inputMock
            ->method('hasArgument')
            ->with('hoge')
            ->willReturn(true);
        $this->setProperty($command, 'input', $inputMock);

        $this->assertTrue($this->callMethod($command, 'hasArgument', 'hoge'));
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
        $this->setProperty($command, 'output', $this->createOutputMock());

        $table = $this->callMethod($command, 'table');

        $this->assertInstanceOf(\Symfony\Component\Console\Helper\Table::class, $table);
    }

    public function testTableSetHeaders()
    {
        $headers = ['name', 'age', 'loc'];

        $command = new ExampleCommand();
        $this->setProperty($command, 'output', $this->createOutputMock());

        $table = $this->callMethod($command, 'table', $headers);

        $this->assertInstanceOf(\Symfony\Component\Console\Helper\Table::class, $table);
        $this->assertNotCount(0, $this->getProperty($table, 'headers'));
    }

    public function testTableSetRows()
    {
        $headers = ['name', 'age', 'loc'];
        $rows = [
            ['a', '10', 'jp'],
            ['b', '20', 'us'],
        ];

        $command = new ExampleCommand();
        $this->setProperty($command, 'output', $this->createOutputMock());

        $table = $this->callMethod($command, 'table', $headers, $rows);

        $this->assertInstanceOf(\Symfony\Component\Console\Helper\Table::class, $table);
        $this->assertNotCount(0, $this->getProperty($table, 'headers'));
        $this->assertNotCount(0, $this->getProperty($table, 'rows'));
    }

    protected function createInputMock()
    {
        return $this->createMock(\Symfony\Component\Console\Input\InputInterface::class);
    }

    protected function createOutputMock()
    {
        return $this->createMock(\Symfony\Component\Console\Output\OutputInterface::class);
    }
}
