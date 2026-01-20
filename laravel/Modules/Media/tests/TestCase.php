<?php

declare(strict_types=1);

namespace Modules\Media\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;
use Modules\Media\Providers\MediaServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Media module tests.
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

        // The Media models expect a "media" connection, but the project may not define it
        // explicitly in config/database.php (it might rely on module config/merge in runtime).
        // For tests, alias "media" to the default mysql connection to ensure the container can
        // resolve the connection consistently.
        if ($this->app['config']->get('database.connections.media') === null) {
            $default = (string) $this->app['config']->get('database.default');
            $fallback = $this->app['config']->get("database.connections.{$default}")
                ?? $this->app['config']->get('database.connections.mysql');

            if (is_array($fallback)) {
                $this->app['config']->set('database.connections.media', $fallback);
            }
        }

        // Use the same DB driver as .env (and .env.testing) to avoid dialect inconsistencies.
        // Run module migrations on the default connection configured in .env.testing.
        $this->artisan('module:migrate', ['module' => 'Xot', '--force' => true]);
        $this->artisan('module:migrate', ['module' => 'User', '--force' => true]);
        $this->artisan('module:migrate', ['module' => 'Media', '--force' => true]);

        // Manual DB transaction, started after the "media" connection alias is configured.
        DB::connection('media')->beginTransaction();

        // Ensure a clean state for each test without using RefreshDatabase.
        // We delete rows (instead of TRUNCATE) to keep the operation transactional.
        try {
            DB::connection('media')->table('media_converts')->delete();
        } catch (\Throwable) {
        }

        try {
            DB::connection('media')->table('media')->delete();
        } catch (\Throwable) {
        }
    }

    /**
     * Teardown the test environment.
     */
    protected function tearDown(): void
    {
        try {
            DB::connection('media')->rollBack();
        } catch (\Throwable) {
        }

        parent::tearDown();
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
            MediaServiceProvider::class,
        ];
    }
}
