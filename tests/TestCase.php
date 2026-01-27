<?php

declare(strict_types=1);

namespace Modules\Geo\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Geo module.
 *
 * Uses MySQL from .env.testing (NOT SQLite).
 * Database names must have "_test" suffix (es: quaeris_data_test).
 * The .env.testing file is the single source of truth - NEVER override database configuration.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();

        // Set cache driver to array for testing (required for Sushi models)
        $this->app['config']->set('cache.default', 'array');

        // ✅ CORRETTO: Rispetta .env.testing - NON forzare SQLite
        // Il file .env.testing è la fonte unica di verità per la configurazione database
        // NON sovrascrivere mai la configurazione database da .env.testing
        // Database test DEVONO avere suffisso "_test" (es: quaeris_data_test)

        $this->artisan('module:migrate', ['module' => 'Xot', '--force' => true]);
        $this->artisan('module:migrate', ['module' => 'User', '--force' => true]);
        $this->artisan('module:migrate', ['module' => 'Geo', '--force' => true]);
    }
}
