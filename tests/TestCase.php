<?php

declare(strict_types=1);

namespace Modules\Geo\Tests;

<<<<<<< HEAD
use GuzzleHttp\Handler\MockHandler;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\ServiceProvider;
use Mockery\MockInterface;
use Modules\Geo\Models\Address;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Providers\GeoServiceProvider;
use Modules\Geo\Services\GoogleMapsService;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * @property object|null            $action
 * @property MockInterface|null     $mockDistanceMatrixAction
 * @property MockInterface|null     $fetchAction
 * @property MockInterface|null     $mockClient
 * @property MockInterface|null     $getCoordinatesAction
 * @property MockHandler|null       $mockHandler
 * @property GoogleMapsService|null $service
 * @property Address|null           $address
 * @property BaseModel|null         $baseModel
 * @property array<string, mixed>   $testData
 * @property array<string, mixed>   $italianAddress
 * @property array<string, mixed>   $geocodingResult
 * @property array<string, mixed>   $weatherData
 * @property array<string, mixed>   $place
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    public ?MockInterface $mockDistanceMatrixAction = null;

    public ?MockInterface $fetchAction = null;

    public ?MockInterface $mockClient = null;

    public ?MockInterface $getCoordinatesAction = null;

    public ?MockHandler $mockHandler = null;

    public ?Address $address = null;

    /** @var array<string, mixed> */
    public array $testData = [];

    /** @var array<string, mixed> */
    public array $italianAddress = [];

    /** @var array<string, mixed> */
    public array $geocodingResult = [];

    /** @var array<string, mixed> */
    public array $weatherData = [];

    /** @var array<string, mixed> */
    public array $place = [];

    /** @var list<string> */
=======
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Modules\Geo\Providers\GeoServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Providers\XotServiceProvider;
use Modules\Xot\Tests\CreatesApplication;

/**
 * Base test case for Geo module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;

>>>>>>> laraxot/dev
    protected $connectionsToTransact = [
        'mysql',
        'user',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        config(['xra.pub_theme' => 'Meetup']);
        config(['xra.main_module' => 'User']);

<<<<<<< HEAD
        XotData::make()->update([
            'pub_theme' => 'Meetup',
            'main_module' => 'User',
        ]);
    }

    /**
     * @return array<int, class-string<ServiceProvider>>
     */
    protected function getPackageProviders(Application $app): array
    {
        return [
            ...parent::getPackageProviders($app),
=======
        \Modules\Xot\Datas\XotData::make()->update([
            'pub_theme' => 'Meetup',
            'main_module' => 'User',
        ]);

        // NOTE: Migrations are NOT run in setUp()
        // They must be run ONCE externally: php artisan migrate --env=testing
        // DatabaseTransactions trait handles rollback automatically between tests
    }

    protected function getPackageProviders($app): array
    {
        return [
            XotServiceProvider::class,
>>>>>>> laraxot/dev
            UserServiceProvider::class,
            GeoServiceProvider::class,
        ];
    }
}
