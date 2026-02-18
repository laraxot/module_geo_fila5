<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests;

use Modules\Xot\Tests\TestCase as XotTestCase;

abstract class TestCase extends XotTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Carica le migrazioni del modulo
        $this->loadMigrationsFrom([
            __DIR__.'/../database/migrations',
        ]);
    }
}
