<?php

$finder = PhpCsFixer\Finder::create()->in(__DIR__);
$rules = [
    '@PSR2' => true,
    'array_syntax' => ['syntax' => 'short'],
    'binary_operator_spaces' => true,
    'blank_line_after_opening_tag' => false,
    'blank_line_before_return' => true,
    'cast_spaces' => true,
    'concat_space' => ['spacing' => 'one'],
    'declare_equal_normalize' => true,
    'full_opening_tag' => false,
    'method_argument_space' => true,
    'method_separation' => true,
    'no_blank_lines_before_namespace' => false,
    'no_break_comment' => false,
    'no_empty_statement' => true,
    'no_leading_import_slash' => true,
    'no_leading_namespace_whitespace' => true,
    'no_multiline_whitespace_around_double_arrow' => true,
    'no_multiline_whitespace_before_semicolons' => true,
    'no_trailing_comma_in_list_call' => true,
    'no_trailing_comma_in_singleline_array' => true,
    'no_unused_imports' => true,
    'no_whitespace_before_comma_in_array' => true,
    'no_whitespace_in_blank_line' => true,
    'ordered_imports' => true,
    'phpdoc_add_missing_param_annotation' => true,
    'phpdoc_align' => true,
    'phpdoc_indent' => true,
    'phpdoc_no_empty_return' => true,
    'phpdoc_order' => true,
    'phpdoc_scalar' => true,
    'phpdoc_separation' => true,
    'return_type_declaration' => true,
    'single_import_per_statement' => false,
    'short_scalar_cast' => true,
    'ternary_operator_spaces' => true,
    'trim_array_spaces' => true
];
return PhpCsFixer\Config::create()
    ->setUsingCache(false)
    ->setRules($rules)
    ->setFinder($finder);