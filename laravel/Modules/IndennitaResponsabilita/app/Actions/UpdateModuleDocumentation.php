<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Actions;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * Action to update module documentation automatically.
 */
class UpdateModuleDocumentation
{
    /**
     * Update documentation for a specific module.
     *
     * @param string $moduleName
     * @param string $description
     * @return void
     */
    public static function execute(string $moduleName, string $description): void
    {
        $modulePath = base_path("Modules/{$moduleName}");
        $docsPath = "{$modulePath}/docs";
        
        if (!is_dir($docsPath)) {
            mkdir($docsPath, 0755, true);
        }
        
        // Update main README if exists
        $readmePath = "{$docsPath}/README.md";
        if (file_exists($readmePath)) {
            self::updateReadme($readmePath, $moduleName, $description);
        }
        
        // Create/update changelog
        $changelogPath = "{$docsPath}/changelog.md";
        self::updateChangelog($changelogPath, $description);
    }
    
    /**
     * Update README file.
     */
    private static function updateReadme(string $path, string $moduleName, string $description): void
    {
        $content = file_get_contents($path);
        $timestamp = now()->format('Y-m-d H:i:s');
        
        // Add to changelog section
        if (str_contains($content, '## Changelog')) {
            $newEntry = "- {$timestamp}: {$description}\n";
            $content = preg_replace(
                '/(## Changelog\s*\n)/',
                "$1{$newEntry}",
                $content
            );
        } else {
            $content .= "\n\n## Changelog\n\n- {$timestamp}: {$description}\n";
        }
        
        file_put_contents($path, $content);
    }
    
    /**
     * Update changelog file.
     */
    private static function updateChangelog(string $path, string $description): void
    {
        $timestamp = now()->format('Y-m-d H:i:s');
        $entry = "- {$timestamp}: {$description}\n";
        
        if (file_exists($path)) {
            file_put_contents($path, $entry . file_get_contents($path));
        } else {
            file_put_contents($path, "# Changelog\n\n{$entry}");
        }
    }
}