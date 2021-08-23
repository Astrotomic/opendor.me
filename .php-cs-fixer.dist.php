<?php

$finder = (new \PhpCsFixer\Finder)
    ->notPath('vendor')
    ->notPath('bootstrap')
    ->notPath('storage')
    ->notName('*.blade.php')
    ->notName('index.php')
    ->notName('server.php')
    ->notName('_ide_helper.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true)
    ->name('*.php')
    ->in(__DIR__);

return (new \PhpCsFixer\Config)
    ->setRules(array_merge(require '.php-cs-rules.laravel.php', [
        '@PSR2' => true,
        '@PSR12' => true,
        'no_unused_imports' => true,
        'phpdoc_to_comment' => false,
        'phpdoc_order' => true,
        'phpdoc_separation' => true,
        'simplified_null_return' => false,
    ]))
    ->setLineEnding("\n")
    ->setIndent(str_repeat(' ', 4))
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
    ->setFinder($finder);
