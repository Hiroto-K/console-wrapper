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

use Psr\Log\AbstractLogger;

/**
 * Class ExampleLogger.
 *
 * @package HirotoK\ConsoleWrapper\Tests\Example
 */
class ExampleLogger extends AbstractLogger
{
    /**
     * @param mixed $level
     * @param string $message
     * @param array $context
     */
    public function log($level, $message, array $context = [])
    {
        // Noop
    }
}
