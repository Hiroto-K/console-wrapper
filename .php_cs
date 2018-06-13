<?php

/*
 * This file is part of console-wrapper.
 *
 * (c) Hiroto Kitazawa <hiro.yo.yo1610@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$header = <<<'EOS'
This file is part of console-wrapper.

(c) Hiroto Kitazawa <hiro.yo.yo1610@gmail.com>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOS;

$rules = [
    '@PSR2' => true,
    '@Symfony' => true,
    'phpdoc_no_package' => false,
    'psr0' => false,
    'binary_operator_spaces' => true,
    'encoding' => true,
    'header_comment' => compact('header'),
    'array_syntax' => ['syntax' => 'short'],
    'ordered_imports' => true,
    'linebreak_after_opening_tag' => true,
    'phpdoc_align' => false,
];

$finder = Finder::create()
    ->ignoreDotFiles(false)
    ->name('.php_cs')
    ->in(__DIR__)
    ->exclude('vendor');

return Config::create()
    ->setRules($rules)
    ->setFinder($finder)
    ->setUsingCache(true);
