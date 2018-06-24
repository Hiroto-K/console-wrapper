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
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Command.
 *
 * @package HirotoK\ConsoleWrapper
 */
abstract class Command extends SymfonyCommand
{
    use LoggerAwareTrait;

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
     * Whether or not the command should be hidden from the list of commands.
     *
     * @var bool
     */
    protected $hidden = false;

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
    protected function setup()
    {
    }

    /**
     * Execute command.
     */
    protected function handle()
    {
        throw new LogicException('You must override the handle() method.');
    }

    /**
     * Configures the command.
     */
    protected function configure()
    {
        $this->setup();

        $this
            ->setName($this->name)
            ->setDescription($this->description)
            ->setHidden($this->hidden);

        foreach ($this->commandArguments() as $arguments) {
            call_user_func_array([$this, 'addArgument'], $arguments);
        }
        foreach ($this->commandOptions() as $options) {
            call_user_func_array([$this, 'addOption'], $options);
        }
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

        return $this->handle();
    }

    /**
     * Get arguments.
     *
     * @param string|null $name argument name
     *
     * @return array|mixed return all arguments if $name is null
     */
    protected function argument($name = null)
    {
        if (is_null($name)) {
            return $this->input->getArguments();
        }

        return $this->input->getArgument($name);
    }

    /**
     * Return all arguments.
     *
     * @return array
     */
    protected function arguments()
    {
        return $this->argument();
    }

    /**
     * Proxy method of InputInterface::hasArgument.
     *
     * @see \Symfony\Component\Console\Input\InputInterface::hasArgument
     *
     * @param string|int $name Argument name
     *
     * @return bool
     */
    protected function hasArgument($name)
    {
        return $this->input->hasArgument($name);
    }

    /**
     * Get options.
     *
     * @param string|null $name option name
     *
     * @return array|mixed return all options if $name is null
     */
    protected function option($name = null)
    {
        if (is_null($name)) {
            return $this->input->getOptions();
        }

        return $this->input->getOption($name);
    }

    /**
     * Return all options.
     *
     * @return array
     */
    protected function options()
    {
        return $this->option();
    }

    /**
     * Proxy method of InputInterface::hasOption.
     *
     * @see \Symfony\Component\Console\Input\InputInterface::hasOption
     *
     * @param string $name Option name
     *
     * @return bool
     */
    protected function hasOption($name)
    {
        return $this->input->hasOption($name);
    }

    /**
     * Proxy method of OutputInterface::writeln.
     *
     * @see \Symfony\Component\Console\Output\OutputInterface::writeln
     *
     * @param string|iterable $messages
     * @param int $options
     *
     * @return mixed
     */
    protected function writeln($messages, $options = 0)
    {
        return $this->output->writeln($messages, $options);
    }

    /**
     * Writeln with info color style.
     *
     * @param string $message
     * @param int $options
     */
    protected function info($message, $options = 0)
    {
        $this->writeln("<info>{$message}</info>", $options);
    }

    /**
     * Writeln with comment color style.
     *
     * @param string $message
     * @param int $options
     */
    protected function comment($message, $options = 0)
    {
        $this->writeln("<comment>{$message}</comment>", $options);
    }

    /**
     * Writeln with question color style.
     *
     * @param string $message
     * @param int $options
     */
    protected function question($message, $options = 0)
    {
        $this->writeln("<question>{$message}</question>", $options);
    }

    /**
     * Writeln with error color style.
     *
     * @param string $message
     * @param int $options
     */
    protected function error($message, $options = 0)
    {
        $this->writeln("<error>{$message}</error>", $options);
    }

    /**
     * Return logger instance.
     *
     * @return \Psr\Log\LoggerInterface
     */
    protected function logger()
    {
        return $this->logger;
    }

    /**
     * @param string $command Command name
     * @param array $parameters Command parameters
     * @return int Exit code
     * @throws \Exception
     */
    protected function callCommand($command, $parameters = []){
        $findCommand = $this->getApplication()->find($command);
        $parameters = array_merge($parameters, compact("command"));
        $arrayInput = new ArrayInput($parameters);

        return $findCommand->run($arrayInput, $this->output);
    }

    /**
     * Set arguments.
     * If using arguments, override this method.
     *
     * @return array[]
     */
    protected function commandArguments()
    {
        return [];
    }

    /**
     * Set options.
     * If using options, override this method.
     *
     * @return array[]
     */
    protected function commandOptions()
    {
        return [];
    }
}
