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

    'array_syntax' => [
        'syntax' => 'short',
    ],
    'combine_consecutive_issets' => true,
    'combine_consecutive_unsets' => true,
    'compact_nullable_typehint' => true,
    'explicit_indirect_variable' => true,
    'explicit_string_variable' => true,
    'header_comment' => [
        'header' => $header,
    ],
    'linebreak_after_opening_tag' => true,
    'list_syntax' => [
        'syntax' => 'long',
    ],
    'multiline_whitespace_before_semicolons' => [
        'strategy' => 'no_multi_line',
    ],
    'ordered_imports' => true,
    'phpdoc_align' => [
        'align' => 'left',
    ],
    'phpdoc_no_package' => false,
    'return_type_declaration' => [
        'space_before' => 'one',
    ],
    'single_line_comment_style' => [
        'comment_types' => ['hash'],
    ],
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
