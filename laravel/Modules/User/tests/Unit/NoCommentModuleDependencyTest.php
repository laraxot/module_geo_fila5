<?php

declare(strict_types=1);

test('it does not reference the comment module anywhere under user app', function (): void {
    $appPath = dirname(__DIR__, 2).'/app';
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($appPath, FilesystemIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if (! $file->isFile() || $file->getExtension() !== 'php') {
            continue;
        }

        if (str_ends_with($file->getFilename(), '.old')) {
            continue;
        }

        $contents = (string) file_get_contents($file->getPathname());

        expect($contents)
            ->not->toContain('Modules\\Comment\\')
            ->not->toContain('InteractsWithComments')
            ->not->toContain('HasCommentatorRelations');
    }
});

test('base user model does not use comment traits', function (): void {
    $baseUserPath = dirname(__DIR__, 2).'/app/Models/BaseUser.php';
    $contents = (string) file_get_contents($baseUserPath);

    expect($contents)
        ->not->toContain('HasCommentatorRelations')
        ->not->toContain('CanComment')
        ->not->toContain('InteractsWithComments');
});
