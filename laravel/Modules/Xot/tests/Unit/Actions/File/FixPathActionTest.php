<?php

declare(strict_types=1);

use Modules\Xot\Actions\File\FixPathAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('normalizes path slashes correctly', function (): void {
    /** @var TestCase $this */
    $action = app(FixPathAction::class);

    $path = 'some/path\with/mixed\\slashes';
    $expected = str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $path);

    Assert::assertSame($expected, $action->execute($path));
});
