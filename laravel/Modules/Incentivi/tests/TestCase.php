<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests;

use Modules\Xot\Tests\TestCase as XotTestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

abstract class TestCase extends XotTestCase
{
    use DatabaseTransactions;

    /**
     * The database connections that should have transactions rolled back.
     *
     * @var array<int, string>
     */
    protected array $connectionsToTransact = ['mysql', 'incentivi', 'user'];

    protected function setUp(): void
    {
        parent::setUp();

        // Forza il purge della connessione incentivi per caricare i dati corretti dal test env
        if ($this->app->bound('db')) {
             $this->app->make('db')->purge('incentivi');
        }

        // Carica le migrazioni del modulo usando artisan migrate
        $this->artisan('migrate', [
            '--path' => 'Modules/Incentivi/database/migrations',
            '--database' => 'incentivi',
            '--realpath' => true,
        ]);
    }
}
