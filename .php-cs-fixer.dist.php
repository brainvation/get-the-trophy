<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->exclude('node_modules')
    ->exclude('bootstrap/cache')
    ->exclude('public/hot')
    ->exclude('public/storage')
    ->exclude('tmp')
    ->in(__DIR__);

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'no_unused_imports' => true,
        'ordered_imports' => ['imports_order' => ['class', 'function', 'const'], 'sort_algorithm' => 'alpha'],
        'align_multiline_comment' => true,
        'blank_line_before_statement' 
            => ['statements' 
                => [
                'break', 
                'case', 
                'continue', 
                'declare', 
                'default', 
                'do', 
                'exit', 
                'for', 
                'foreach', 
                'goto', 
                'if', 
                'include', 
                'include_once', 
                'require', 
                'require_once', 
                'return', 
                'switch', 
                'throw', 
                'try', 
                'while']],
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
    ])
    ->setFinder($finder)
;
