<?php

/*
 * This file is part of console-wrapper.
 *
 * (c) Hiroto Kitazawa <hiro.yo.yo1610@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HirotoK\ConsoleWrapper;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Application as SymfonyApplication;

/**
 * Class Application.
 *
 * @package HirotoK\ConsoleWrapper
 */
class Application extends SymfonyApplication implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * Get logger instance.
     *
     * @return \Psr\Log\LoggerInterface
     */
    public function logger()
    {
        if ($this->logger) {
            return $this->logger;
        }

        return new NullLogger();
    }
}
