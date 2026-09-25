<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Traits;

<<<<<<< HEAD
use Modules\Geo\Models\Traits\HasAddress;
use Modules\Geo\Tests\Fixtures\Traits\HasAddressTestModel;
use PHPUnit\Framework\Assert;

/*
 * Pest: verifica API del trait HasAddress sulla fixture canonica HasAddressTestModel.
 * Non istanziare Worker/TechPlanner né duplicare modelli fixture in Unit/Traits.
 */
test('HasAddressTestModel uses HasAddress trait', function (): void {
    Assert::assertContains(
        HasAddress::class,
        class_uses_recursive(HasAddressTestModel::class),
    );
});

test('HasAddress trait exposes expected methods', function (): void {
    $reflection = new \ReflectionClass(HasAddress::class);

    Assert::assertTrue($reflection->hasMethod('addresses'));
    Assert::assertTrue($reflection->hasMethod('address'));
    Assert::assertTrue($reflection->hasMethod('addAddress'));
    Assert::assertTrue($reflection->hasMethod('getFullAddress'));
    Assert::assertTrue($reflection->hasMethod('scopeInCity'));
});
=======
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Traits\HasAddress;

/**
 * Modello di test per il trait HasAddress.
 */
class HasAddressTest extends BaseModel
{
    use HasAddress;

    protected $fillable = ['name'];

    public $timestamps = false;

    protected $table = 'test_models';

    /**
     * Override connection for testing - use default connection.
     */
    protected $connection;

    /**
     * Bootstrap this model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(static function () {
            if (! app()->environment('testing')) {
                throw new \Exception('TestModel should only be used in tests.');
            }
        });
    }
}
>>>>>>> laraxot/dev
