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

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Application as SymfonyApplication;

/**
 * Class Application.
 *
 * @package HirotoK\ConsoleWrapper
 */
class Application extends SymfonyApplication
{
    /**
     * Logger instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

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

        return new NullLogger;
    }

    /**
     * Set logger instance.
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
}
