<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

/**
 * Rector Configuration for Sigma Module
 *
 * Configuration for automatic refactoring of legacy code
 * Updated: Gennaio 2025
 *
 * Include Rector Laravel rules for Laravel-specific refactoring
 */
return static function (RectorConfig $rectorConfig): void {
    // Paths to analyze
    $rectorConfig->paths([
        __DIR__.'/app',
    ]);

    // Paths to skip
    $rectorConfig->skip([
        __DIR__.'/vendor',
        __DIR__.'/docs',
        __DIR__.'/database/migrations_check',
        __DIR__.'/app/Models/Traits/Extras/FunctionExtra.php', // Skip per ora - refactoring manuale necessario
        __DIR__.'/app/Models/Traits/Extras/MassExtra.php', // Skip per ora - refactoring manuale necessario
    ]);

    // PHP version target
    $rectorConfig->phpVersion(\Rector\ValueObject\PhpVersion::PHP_83);

    // Rule sets
    $laravelSets = [];

    if (class_exists(\RectorLaravel\Set\LaravelSetList::class)) {
        $laravelSets[] = \RectorLaravel\Set\LaravelSetList::LARAVEL_100; // Laravel 10.0 rules
        $laravelSets[] = \RectorLaravel\Set\LaravelSetList::LARAVEL_CODE_QUALITY; // Laravel code quality improvements
        $laravelSets[] = \RectorLaravel\Set\LaravelSetList::LARAVEL_ARRAY_STR_FUNCTION_TO_STATIC_CALL; // Convert array/str functions to static calls
    }

    $rectorConfig->sets(array_merge($laravelSets, [
        // PHP 8.3 compatibility
        LevelSetList::UP_TO_PHP_83,

        // Code quality improvements
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,

        // Type declarations (attento - può causare breaking changes)
        // SetList::TYPE_DECLARATION,

        // Coding style
        // SetList::CODING_STYLE,
    ]));

    // Import names for cleaner code
    $rectorConfig->importNames();

    // Import short classes
    $rectorConfig->importShortClasses(false);
};
