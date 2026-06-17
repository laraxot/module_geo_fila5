<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Filament;

use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

/**
 * @return list<array{0: string, 1: string}>
 */
function filamentConcreteResourceClasses(): array
{
    /** @var list<string> $skip */
    $skip = [
        'BaseSchedaResource',
        'BaseStabiDirigenteResource',
        'LangBaseResource',
    ];

    $cases = [];
    $modulesRoot = base_path('Modules');

    foreach (glob($modulesRoot.'/*/app/Filament/Resources/*Resource.php') ?: [] as $file) {
        $resourceName = basename($file, '.php');
        if (in_array($resourceName, $skip, true)) {
            continue;
        }

        $moduleName = basename(dirname(dirname(dirname(dirname($file)))));
        $class = "Modules\\{$moduleName}\\Filament\\Resources\\{$resourceName}";

        if (! class_exists($class)) {
            continue;
        }

        $ref = new \ReflectionClass($class);
        if ($ref->isAbstract()) {
            continue;
        }

        $cases[] = [$class, $file];
    }

    return $cases;
}

function filamentResolveModelBasename(string $resourceFile, string $resourceName): string
{
    $content = file_get_contents($resourceFile);
    if (false !== $content) {
        foreach (explode("\n", $content) as $line) {
            $trimmed = ltrim($line);
            if (str_starts_with($trimmed, '//') || str_starts_with($trimmed, '*')) {
                continue;
            }

            if (! preg_match('/protected\s+static\s+\?string\s+\$model\s*=\s*([^;]+);/', $line, $m)) {
                continue;
            }

            $expr = trim($m[1]);
            if (preg_match('/^((?:\\\\)?[\w\\\\]+)::class$/', $expr, $m2)) {
                return class_basename(ltrim($m2[1], '\\'));
            }
        }
    }

    return str_replace('Resource', '', $resourceName);
}

function filamentSchemaIsPopulated(string $path, string $method): bool
{
    if (! is_file($path)) {
        return false;
    }

    $content = file_get_contents($path);
    if (false === $content || ! preg_match('/function\s+'.preg_quote($method, '/').'\s*\([^)]*\)[^{]*\{([^}]*)\}/s', $content, $m)) {
        return false;
    }

    $body = trim($m[1]);

    return '' !== $body && 'return [];' !== $body && "return [\n        ];" !== $body;
}

test('every concrete filament resource has populated schemas and table classes', function (): void {
    foreach (filamentConcreteResourceClasses() as [$resourceClass, $resourceFile]) {
        $resourceName = class_basename($resourceClass);
        $moduleName = explode('\\', $resourceClass)[1];
        $modelBasename = filamentResolveModelBasename($resourceFile, $resourceName);

        $baseDir = dirname($resourceFile).'/'.$resourceName;
        $formPath = $baseDir.'/Schemas/'.$modelBasename.'Form.php';
        $infolistPath = $baseDir.'/Schemas/'.$modelBasename.'Infolist.php';
        $tablesDir = $baseDir.'/Tables';

        expect(filamentSchemaIsPopulated($formPath, 'getFormSchema'))
            ->toBeTrue("Missing or empty form schema: {$formPath}");

        expect(filamentSchemaIsPopulated($infolistPath, 'getInfolistSchema'))
            ->toBeTrue("Missing or empty infolist schema: {$infolistPath}");

        $tableFiles = glob($tablesDir.'/*Table.php') ?: [];
        expect($tableFiles)->toHaveCount(1, "Expected exactly one table class in {$tablesDir}");

        $tableFile = $tableFiles[0];
        $tableClass = "Modules\\{$moduleName}\\Filament\\Resources\\{$resourceName}\\Tables\\".basename($tableFile, '.php');
        expect(class_exists($tableClass))->toBeTrue();

        $table = app($tableClass);
        expect($table)->toBeInstanceOf(XotBaseResourceTable::class);

        $columns = $table->getTableColumns();
        expect($columns)->toBeArray()->not->toBeEmpty();

        foreach (array_keys($columns) as $key) {
            expect($key)->toBeString();
        }
    }
});
