<?php declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(['src', 'tests']);

return (new PhpCsFixer\Config())
    ->setFinder($finder)
    ->setRules(['@PSR12' => true]);
