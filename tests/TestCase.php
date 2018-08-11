<?php

/*
 * This file is part of console-wrapper.
 *
 * (c) Hiroto Kitazawa <hiro.yo.yo1610@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HirotoK\ConsoleWrapper\Tests;

/**
 * Class TestCase.
 *
 * @package HirotoK\ConsoleWrapper\Tests
 */
abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * Get the property name.
     *
     * @param object $obj
     * @param string $propertyName
     *
     * @return mixed
     *
     * @throws \ReflectionException
     */
    protected function getProperty($obj, $propertyName)
    {
        $reflection = new \ReflectionClass($obj);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getValue($obj);
    }

    /**
     * Set the property value.
     *
     * @param object $obj
     * @param string $propertyName
     * @param mixed $propertyValue
     *
     * @throws \ReflectionException
     */
    protected function setProperty($obj, $propertyName, $propertyValue)
    {
        $reflection = new \ReflectionClass($obj);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($obj, $propertyValue);
    }

    /**
     * Call private and protected method.
     *
     * @param object $obj
     * @param string $methodName
     * @param mixed ...$args
     *
     * @return mixed
     *
     * @throws \ReflectionException
     */
    protected function callMethod($obj, $methodName, ...$args)
    {
        $reflection = new \ReflectionClass($obj);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invoke($obj, ...$args);
    }
}
