<?php

/*
 * This file is part of console-wrapper.
 *
 * (c) Hiroto Kitazawa <hiroto.ktzw@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HirotoK\ConsoleWrapper\CommandFinder;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Class FindByPsr4.
 *
 * @package HirotoK\ConsoleWrapper\CommandFinder
 */
class FindByPsr4
{
    /**
     * Namespace prefix.
     *
     * @var string
     */
    protected $nameSpacePrefix;

    /**
     * Target directory path.
     *
     * @var string
     */
    protected $targetDir;

    /**
     * CommandFinder constructor.
     *
     * @param string $nameSpacePrefix
     * @param string $targetDir
     */
    public function __construct($nameSpacePrefix, $targetDir)
    {
        if ('\\' !== $nameSpacePrefix[0]) {
            $nameSpacePrefix = '\\'.$nameSpacePrefix;
        }

        $this->nameSpacePrefix = $nameSpacePrefix;
        $this->targetDir = $targetDir;
    }

    /**
     * Get command classes.
     *
     * @return string[]
     */
    public function getClasses()
    {
        $classes = [];

        foreach ($this->findPhpFiles() as $filePath) {
            $classes[] = $this->filePathToClassName($filePath);
        }

        return $classes;
    }

    /**
     * Get php files by $baseDir.
     *
     * @return \Generator
     */
    protected function findPhpFiles()
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->targetDir));
        $extension = 'php';

        foreach ($iterator as $fileInfo) {
            /** @var \SplFileInfo $fileInfo */
            if ($fileInfo->isFile() && $fileInfo->getExtension() === $extension) {
                yield $fileInfo->getRealPath();
            }
        }
    }

    /**
     * Convert to class name from file path.
     *
     * @param string $filePath
     *
     * @return string
     */
    protected function filePathToClassName(string $filePath)
    {
        $className = str_replace([$this->targetDir, '.php'], '', $filePath);
        $className = str_replace('/', '\\', $className);

        return $this->nameSpacePrefix.$className;
    }
}
