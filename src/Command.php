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

use HirotoK\ConsoleWrapper\Exception\LogicException;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Command.
 *
 * @package HirotoK\ConsoleWrapper
 */
abstract class Command extends SymfonyCommand
{
    /**
     * Command name.
     *
     * @var string
     */
    protected $name;

    /**
     * Command description.
     *
     * @var string
     */
    protected $description;

    /**
     * InputInterface instance.
     *
     * @var \Symfony\Component\Console\Input\InputInterface
     */
    protected $input;

    /**
     * OutputInterface instance.
     *
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    protected $output;

    /**
     * Configure command.
     */
    protected function setup(){
    }

    /**
     * Execute command.
     */
    protected function handle(){
        throw new LogicException('You must override the handle() method.');
    }

    /**
     * Configures the command.
     */
    protected function configure()
    {
    }

    /**
     * Execute the command.
     *
     * @param \Symfony\Component\Console\Input\InputInterface  $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }
}
