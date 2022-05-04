<?php

$finder = (new \PhpCsFixer\Finder)
    ->in([
        __DIR__.'/app',
        __DIR__.'/config',
        __DIR__.'/database',
        __DIR__.'/resources',
        __DIR__.'/routes',
        __DIR__.'/tests',
    ])
    ->notPath('vendor')
    ->notPath('bootstrap')
    ->notPath('node_modules')
    ->notPath('storage')
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new \PhpCsFixer\Config)
    ->registerCustomFixers([
        new \AdamWojs\PhpCsFixerPhpdocForceFQCN\Fixer\Phpdoc\ForceFQCNFixer(),
    ])
    ->registerCustomFixers(new \PhpCsFixerCustomFixers\Fixers())
    ->setRules(array_merge(require '.php-cs-rules.laravel.php', [
        '@PSR2' => true,
        '@PSR12' => true,
        'no_unused_imports' => true,
        'phpdoc_to_comment' => false,
        'phpdoc_order' => true,
        'phpdoc_separation' => true,
        'simplified_null_return' => false,
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => [
                'class',
                'function',
                'const',
            ],
        ],
        'AdamWojs/phpdoc_force_fqcn_fixer' => true,
        'class_reference_name_casing' => true,
        \PhpCsFixerCustomFixers\Fixer\CommentSurroundedBySpacesFixer::name() => true,
        \PhpCsFixerCustomFixers\Fixer\MultilinePromotedPropertiesFixer::name() => true,
        \PhpCsFixerCustomFixers\Fixer\ConstructorEmptyBracesFixer::name() => true,
        \PhpCsFixerCustomFixers\Fixer\NoCommentedOutCodeFixer::name() => true,
        \PhpCsFixerCustomFixers\Fixer\PhpdocSingleLineVarFixer::name() => true,
        \PhpCsFixerCustomFixers\Fixer\PhpdocArrayStyleFixer::name() => true,
        \PhpCsFixerCustomFixers\Fixer\PhpdocTypesCommaSpacesFixer::name() => true,
        \PhpCsFixerCustomFixers\Fixer\PromotedConstructorPropertyFixer::name() => true,
        \PhpCsFixerCustomFixers\Fixer\SingleSpaceAfterStatementFixer::name() => true,
        \PhpCsFixerCustomFixers\Fixer\SingleSpaceBeforeStatementFixer::name() => true,
        \PhpCsFixerCustomFixers\Fixer\StringableInterfaceFixer::name() => true,
        \PhpCsFixerCustomFixers\Fixer\MultilineCommentOpeningClosingAloneFixer::name() => true,
        \PhpCsFixerCustomFixers\Fixer\NoUselessCommentFixer::name() => true,
    ]))
    ->setLineEnding("\n")
    ->setIndent(str_repeat(' ', 4))
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
    ->setFinder($finder);
