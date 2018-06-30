<?php

/*
 * This file is part of console-wrapper.
 *
 * (c) Hiroto Kitazawa <hiro.yo.yo1610@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HirotoK\ConsoleWrapper\Tests\Examples;

use HirotoK\ConsoleWrapper\Application;

/**
 * Class ExampleOverrideDefaultLoggerApplication.
 *
 * @package HirotoK\ConsoleWrapper\Tests\Examples
 */
class ExampleOverrideDefaultLoggerApplication extends Application
{
    protected function createDefaultLogger()
    {
        return new ExampleLogger();
    }
}
