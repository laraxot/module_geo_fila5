<?php

declare(strict_types=1);

namespace Modules\Geo\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Geo module tests — schema is provisioned outside the suite.
 * Never RefreshDatabase / module:migrate here: they mutate shared `*_test` DBs.
 */
abstract class TestCase extends XotBaseTestCase
{
    protected function setUp(): void
    {
        // Prima di parent::setUp(): DatabaseTransactions apre le transazioni subito; senza questo la
        // connessione `user` (mysql) va in "Connection refused" dove non c'e' MariaDB (vedi XotBaseTestCase).
        $this->prepareSharedSqliteForTesting();

        parent::setUp();
    }

    use DatabaseTransactions;

    /**
     * Connessioni da riportare indietro dopo ogni test. Prima elencava `fixcity`, la connessione di
     * un altro progetto: in ogni altro progetto ogni test falliva con «connection [fixcity] not configured».
     *
     * @return list<string>
     */
    protected function connectionsToTransact()
    {
        $default = config('database.default');

        return array_values(array_unique(array_filter([\is_string($default) ? $default : null, 'user', 'geo'])));
    }
}
