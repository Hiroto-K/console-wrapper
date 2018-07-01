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
        $inputDefinition = $command->getDefinition();

        $reflection = new \ReflectionClass($inputDefinition);
        $property = $reflection->getProperty('arguments');
        $property->setAccessible(true);

        $arguments = $property->getValue($inputDefinition);

        $this->assertArrayHasKey('first-name', $arguments);
        $this->assertArrayHasKey('family-name', $arguments);
    }

    public function testCommandOptions()
    {
        $command = new ExampleCommand();
        $inputDefinition = $command->getDefinition();

        $reflection = new \ReflectionClass($inputDefinition);
        $property = $reflection->getProperty('options');
        $property->setAccessible(true);

        $options = $property->getValue($inputDefinition);

        $this->assertArrayHasKey('greeting', $options);
    }
}
