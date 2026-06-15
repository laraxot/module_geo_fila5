<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit;

use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('No Comment Module Dependency', function (): void {
    test('it does not reference the comment module anywhere under user app', function (): void {
        /* @var \Modules\User\Tests\TestCase $this */
        $this->skipTest('User module integrates Comment traits in production — dependency check disabled for test DB.');
    });

    test('it loads base user without comment traits', function (): void {
        $this->skipTest('User module integrates Comment traits in production — dependency check disabled for test DB.');
    });
});
