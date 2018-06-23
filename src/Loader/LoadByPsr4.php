<?php
namespace HirotoK\ConsoleWrapper\Loader;

/**
 * Class LoadByPsr4
 * @package HirotoK\ConsoleWrapper\Loader
 */
class LoadByPsr4{

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