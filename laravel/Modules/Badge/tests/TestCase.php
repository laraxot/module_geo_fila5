<?php

declare(strict_types=1);

namespace Modules\Badge\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Badge\Providers\BadgeServiceProvider;

/**
 * Base test case for Badge module tests.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Load Badge module specific configurations
        $this->artisan('migrate', ['--database' => 'testing']);

        // Seed any required data for Badge tests
        $this->artisan('module:seed', ['module' => 'Badge']);
    }

    /**
     * Get package providers.
     *
     * @param  Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            BadgeServiceProvider::class,
        ];
    }
}
