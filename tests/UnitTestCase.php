<?php

declare(strict_types=1);

namespace Tests\Modules\Geo;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Geo\Providers\GeoServiceProvider;
use Modules\Xot\Providers\XotServiceProvider;
use Tests\Modules\Xot\CreatesApplication;

/**
 * Lightweight TestCase for pure unit tests in the Geo module.
 * No database connections — uses SQLite in-memory from phpunit.xml env.
 */
abstract class UnitTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @return array<int, class-string>
     */
    protected function getPackageProviders(Application $app): array
    {
        return [
            XotServiceProvider::class,
            GeoServiceProvider::class,
        ];
    }
}
