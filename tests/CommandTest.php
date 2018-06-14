<?php
namespace HirotoK\ConsoleWrapper\Tests;
use HirotoK\ConsoleWrapper\Command;
use PHPUnit\Framework\TestCase;

/**
 * Class CommandTest
 * @package HirotoK\ConsoleWrapper\Tests
 */
class CommandTest extends TestCase {

    public function testName(){
        $class = new class extends Command{
            protected $name = "test:name";
        };

        $this->assertSame("test:name", $class->getName());
    }

    public function testDescription(){
        $class = new class extends Command{
            protected $name = "example";
            protected $description = "This is a test description.";
        };

        $this->assertSame("This is a test description.", $class->getDescription());
    }

}