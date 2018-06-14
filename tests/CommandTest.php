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

use HirotoK\ConsoleWrapper\Command;
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
        $command = new class() extends Command {
            protected $name = 'test:name';
            protected $description = 'example';
        };

        $this->assertSame('test:name', $command->getName());
    }

    public function testDescription()
    {
        $command = new class() extends Command {
            protected $name = 'example';
            protected $description = 'This is a test description.';
        };

        $this->assertSame('This is a test description.', $command->getDescription());
    }
}
