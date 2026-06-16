<?php

declare(strict_types=1);

namespace Modules\Notify\Tests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Fixcity\Models\User;
use Modules\Notify\Providers\NotifyServiceProvider;
use Modules\Notify\Services\NotificationManager;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;

/**
 * Base test case for Notify module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 * Migrations must be run ONCE externally: php artisan migrate --env=testing
 * DatabaseTransactions handles rollback between tests.
 * @property object|null $notificationManager
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    /** @var list<string> */
    protected $connectionsToTransact = ['sqlite', 'notify', 'user'];

    public ?NotificationManager $notificationManager = null;

    protected function setUp(): void
    {
        parent::setUp();

        $database = database_path('fixcity_data.sqlite');

        /** @var array<string, array<string, mixed>> $connections */
        $connections = config('database.connections', []);

        foreach (array_keys($connections) as $connection) {
            if (config("database.connections.{$connection}.driver") !== 'sqlite') {
                continue;
            }

            $this->app['config']->set("database.connections.{$connection}.database", $database);
            DB::purge($connection);
        }

        config(['auth.providers.users.model' => User::class]);
    }

    protected function getPackageProviders(Application $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            NotifyServiceProvider::class,
        ];
    }

    /**
     * @template T of Model
     *
     * @param  T  $model
     * @param  class-string<T>  $class
     * @return T
     */
    public function freshModel(Model $model, string $class)
    {
        $fresh = $model->fresh();
        Assert::assertInstanceOf($class, $fresh);

        return $fresh;
    }

    /**
     * @template T of Model
     *
     * @param  Collection<int, T>  $collection
     * @param  class-string<T>  $class
     * @return T
     */
    public function firstModel(Collection $collection, string $class)
    {
        $first = $collection->first();
        Assert::assertInstanceOf($class, $first);

        return $first;
    }

    public function notificationManager(): NotificationManager
    {
        Assert::assertNotNull($this->notificationManager);

        return $this->notificationManager;
    }
}
