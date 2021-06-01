<?php

$rules = [
    '@PSR12' => true,
    'array_syntax' => ['syntax' => 'short'],
    'single_quote' => ['strings_containing_single_quote_chars' => true],
];

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . DIRECTORY_SEPARATOR . "src")
    ->in(__DIR__ . DIRECTORY_SEPARATOR . "tests");

return (new PhpCsFixer\Config())
    ->setRules($rules)
    ->setFinder($finder);
