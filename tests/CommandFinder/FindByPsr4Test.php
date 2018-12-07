<?php

/*
 * This file is part of console-wrapper.
 *
 * (c) Hiroto Kitazawa <hiro.yo.yo1610@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HirotoK\ConsoleWrapper\Tests\CommandFinder;

use HirotoK\ConsoleWrapper\CommandFinder\FindByPsr4;
use PHPUnit\Framework\TestCase;

/**
 * Class FindByPsr4Test.
 *
 * @package HirotoK\ConsoleWrapper\Tests\CommandFinder
 */
class FindByPsr4Test extends TestCase
{
    public function testGetClasses()
    {
        $finder = new FindByPsr4('\HirotoK\ConsoleWrapper\Tests', realpath(__DIR__.'/../'));

        $classes = $finder->getClasses();
        $this->assertContainsOnly('string', $classes, true);
        $this->assertContains('\HirotoK\ConsoleWrapper\Tests\ApplicationTest', $classes);
        $this->assertContains('\HirotoK\ConsoleWrapper\Tests\CommandFinder\FindByPsr4Test', $classes);
        $this->assertContains('\HirotoK\ConsoleWrapper\Tests\Examples\ExampleLogger', $classes);
    }

    public function testGetClassesNameSpacePrefix()
    {
        $finder = new FindByPsr4('HirotoK\ConsoleWrapper\Tests', realpath(__DIR__.'/../'));

        $classes = $finder->getClasses();
        $this->assertContainsOnly('string', $classes, true);
        $this->assertContains('\HirotoK\ConsoleWrapper\Tests\ApplicationTest', $classes);
        $this->assertContains('\HirotoK\ConsoleWrapper\Tests\CommandFinder\FindByPsr4Test', $classes);
        $this->assertContains('\HirotoK\ConsoleWrapper\Tests\Examples\ExampleLogger', $classes);
    }
}
