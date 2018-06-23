<?php

/*
 * This file is part of console-wrapper.
 *
 * (c) Hiroto Kitazawa <hiro.yo.yo1610@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace HirotoK\ConsoleWrapper\Loader;

/**
 * Class LoadByPsr4.
 *
 * @package HirotoK\ConsoleWrapper\Loader
 */
class LoadByPsr4
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
        $this->nameSpacePrefix = $nameSpacePrefix;
        $this->targetDir = $targetDir;
    }
}
