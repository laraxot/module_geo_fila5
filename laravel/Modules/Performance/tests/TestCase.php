<?php

declare(strict_types=1);

namespace Modules\Performance\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Configurazione specifica per il modulo Performance
        $this->withoutExceptionHandling();
    }
}
