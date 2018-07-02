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

use HirotoK\ConsoleWrapper\CommandFinder\FindByPsr4;
use HirotoK\ConsoleWrapper\Exception\LogicException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class Application.
 *
 * @package HirotoK\ConsoleWrapper
 */
class Application extends SymfonyApplication implements LoggerAwareInterface
{
    /**
     * The logger instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Default logger instance.
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $defaultLogger;

    /**
     * {@inheritdoc}
     *
     * @param \Symfony\Component\Console\Command\Command $command
     *
     * @return \Symfony\Component\Console\Command\Command|null
     */
    public function add(SymfonyCommand $command)
    {
        $this->setLoggerToCommand($command);

        return parent::add($command);
    }

    /**
     * Load commands by psr4.
     *
     * @param string $nameSpacePrefix
     * @param string $targetDir
     */
    public function loadByPsr4($nameSpacePrefix, $targetDir)
    {
        $finder = new FindByPsr4($nameSpacePrefix, $targetDir);

        foreach ($finder->getClasses() as $class) {
            $command = new $class();
            $this->add($command);
        }
    }

    /**
     * Get logger instance.
     *
     * @return \Psr\Log\LoggerInterface
     */
    public function logger()
    {
        if (isset($this->logger)) {
            return $this->logger;
        }

        if (!isset($this->defaultLogger)) {
            $defaultLogger = $this->createDefaultLogger();

            if ($defaultLogger instanceof LoggerInterface) {
                throw new LogicException('Default logger must be implement the "\Psr\Log\LoggerInterface".');
            }

            $this->defaultLogger = $defaultLogger;
        }

        return $this->defaultLogger;
    }

    /**
     * Sets a logger.
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        foreach ($this->all() as $name => $command) {
            $this->setLoggerToCommand($command);
        }
    }

    /**
     * Sets logger instance to command instance.
     *
     * @param \Symfony\Component\Console\Command\Command $command
     */
    protected function setLoggerToCommand(SymfonyCommand $command)
    {
        if ($command instanceof Command || $command instanceof LoggerAwareInterface) {
            $command->setLogger($this->logger());
        }
    }

    /**
     * Gets the default input definition.
     *
     * @return \Symfony\Component\Console\Input\InputDefinition
     */
    protected function getDefaultInputDefinition()
    {
        $definition = parent::getDefaultInputDefinition();

        $options = $this->globalOptions();
        foreach ($options as $option) {
            $inputOption = new InputOption(...$option);
            $definition->addOption($inputOption);
        }

        return $definition;
    }

    /**
     * Create default logger instance.
     *
     * @return \Psr\Log\LoggerInterface
     */
    protected function createDefaultLogger()
    {
        return new NullLogger();
    }

    /**
     * Set global options.
     * If set global option, override this method.
     *
     * @return array
     */
    protected function globalOptions()
    {
        return [];
    }
}
