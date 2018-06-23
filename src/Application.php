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

use Symfony\Component\Console\Application as SymfonyApplication;
use Psr\Log\LoggerInterface;

/**
 * Class Application.
 *
 * @package HirotoK\ConsoleWrapper
 */
class Application extends SymfonyApplication
{

    /**
     * Logger instance
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Get logger instance
     * @return \Psr\Log\LoggerInterface
     */
    public function logger(){
        return $this->logger;
    }

    /**
     * Set logger instance
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger){
        $this->logger = $logger;
    }
}
