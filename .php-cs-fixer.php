<?php

$header = <<<'EOF'
This file is part of Agarwood Cloud.

@link     https://www.agarwood-cloud.com
@document https://www.agarwood-cloud.com/docs
@contact  676786620@qq.com
@author   agarwood
EOF;

return (new PhpCsFixer\Config)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2'                       => true,
        'array_syntax'                => [
            'syntax' => 'short'
        ],
        'class_attributes_separation' => true,
        'declare_strict_types'        => true,
        'encoding'                    => true, // MUST use only UTF-8 without BOM
        'global_namespace_import'     => [
            'import_constants' => true,
            'import_functions' => true,
        ],
        'header_comment'              => [
            'comment_type' => 'PHPDoc',
            'header'       => $header,
            'separate'     => 'bottom'
        ],
        'no_unused_imports'           => true,
        'single_quote'                => true,
        'standardize_not_equals'      => true,
        'binary_operator_spaces'      => ['default' => 'align_single_space'], //等号对齐、数字箭头符号对齐
        'no_empty_statement'          => true, //多余的分号
        'no_extra_blank_lines'        => true, //多余空白行
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('public')
            ->exclude('resource')
            ->exclude('config')
            ->exclude('runtime')
            ->exclude('vendor')
            ->in(__DIR__)
    )
    ->setUsingCache(false);
