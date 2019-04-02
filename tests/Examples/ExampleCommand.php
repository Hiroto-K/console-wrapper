<?php

/*
 * This file is part of console-wrapper.
 *
 * (c) Hiroto Kitazawa <hiroto.ktzw@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HirotoK\ConsoleWrapper\Tests\Examples;

use HirotoK\ConsoleWrapper\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class ExampleCommand.
 *
 * @package HirotoK\ConsoleWrapper\Tests\Examples
 */
class ExampleCommand extends Command
{
    protected $name = 'example:command';
    protected $description = 'This is a test description';
    protected $hidden = true;

    protected function commandArguments()
    {
        return [
            ['first-name', InputArgument::REQUIRED, 'Your first name (required)'],
            ['family-name', InputArgument::OPTIONAL, 'Your family name (optional)'],
        ];
    }

    protected function commandOptions()
    {
        return [
            ['greeting', 'g', InputOption::VALUE_NONE, 'Output greeting'],
        ];
    }
}
