<?php

declare(strict_types=1);

use Modules\Xot\Actions\Debug\MeasureAction;
use PHPUnit\Framework\Assert;

uses(Modules\Xot\Tests\TestCase::class);

it('measures performance', function (): void {
    $action = app(MeasureAction::class);
    $result = $action->execute(function () {
        return 'done';
    }, 'Test Measurement');

    Assert::assertSame('done', $result);
});
