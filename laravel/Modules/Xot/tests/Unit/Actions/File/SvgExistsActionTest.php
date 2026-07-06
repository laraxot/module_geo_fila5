<?php

declare(strict_types=1);

use Modules\Xot\Actions\File\SvgExistsAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('verifies svg existence', function (): void {
    /** @var TestCase $this */
    // Factory is final, we check with a real instance if possible or just test logic flow
    $action = app(SvgExistsAction::class);

    // Empty name
    Assert::assertFalse($action->execute(''));
    // We can't easily ensure a real icon exists without registering one,
    // but the try/catch block will return false if it's missing.
    Assert::assertFalse($action->execute('non-existent-icon-123456'));
});
