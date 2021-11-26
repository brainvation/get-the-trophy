<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->exclude('node_modules')
    ->exclude('bootstrap/cache')
    ->exclude('public/hot')
    ->exclude('public/storage')
    ->in(__DIR__);

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder)
;
