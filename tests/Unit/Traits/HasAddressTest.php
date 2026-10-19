<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Traits;

use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Traits\HasAddress;
use Tests\TestCase;

/** Modello persistente usato per verificare HasAddress. */
class HasAddressTestModel extends BaseModel
{
    use HasAddress;

    protected $fillable = ['name'];

    public $timestamps = false;

    protected $table = 'test_models';

    protected $connection;

    public static function boot(): void
    {
        parent::boot();

        static::creating(static function (): void {
            if (! app()->environment('testing')) {
                throw new \RuntimeException('HasAddressTestModel should only be used in tests.');
            }
        });
    }
}

final class HasAddressTest extends TestCase
{
    private HasAddressTestModel $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = HasAddressTestModel::create(['name' => 'Test Model']);
    }

    public function testItCanHaveMultipleAddresses(): void
    {
        $this->model->addresses()->create([
            'route' => 'Via Roma', 'street_number' => '123', 'locality' => 'Milano',
            'postal_code' => '20100', 'is_primary' => true,
        ]);
        $this->model->addresses()->create([
            'route' => 'Via Garibaldi', 'street_number' => '456', 'locality' => 'Roma',
            'postal_code' => '00100', 'is_primary' => false,
        ]);

        self::assertCount(2, $this->model->addresses);
    }

    public function testItCanGetPrimaryAddress(): void
    {
        $this->model->addresses()->create([
            'route' => 'Via Roma', 'street_number' => '123', 'locality' => 'Milano',
            'postal_code' => '20100', 'is_primary' => true,
        ]);
        $this->model->addresses()->create([
            'route' => 'Via Garibaldi', 'street_number' => '456', 'locality' => 'Roma',
            'postal_code' => '00100', 'is_primary' => false,
        ]);

        $primaryAddress = $this->model->primaryAddress();
        self::assertNotNull($primaryAddress);
        self::assertSame('Via Roma', $primaryAddress->route);
    }

    public function testItCanSetPrimaryAddress(): void
    {
        $address1 = $this->model->addresses()->create([
            'route' => 'Via Roma', 'street_number' => '123', 'locality' => 'Milano',
            'postal_code' => '20100', 'is_primary' => true,
        ]);
        $address2 = $this->model->addresses()->create([
            'route' => 'Via Garibaldi', 'street_number' => '456', 'locality' => 'Roma',
            'postal_code' => '00100', 'is_primary' => false,
        ]);

        $this->model->setAsPrimaryAddress($address2);
        $address1->refresh();
        $address2->refresh();

        self::assertFalse($address1->is_primary);
        self::assertTrue($address2->is_primary);
    }

    public function testItCanGetFormattedAddress(): void
    {
        $this->model->addresses()->create([
            'route' => 'Via Roma', 'street_number' => '123', 'locality' => 'Milano',
            'postal_code' => '20100', 'is_primary' => true,
        ]);

        $fullAddress = $this->model->getFullAddress();
        self::assertNotNull($fullAddress);
        self::assertStringContainsString('Via Roma', $fullAddress);
        self::assertStringContainsString('Milano', $fullAddress);
    }

    public function testItCanFilterModelsByCity(): void
    {
        $model1 = HasAddressTestModel::create(['name' => 'Model 1']);
        $model1->addresses()->create([
            'route' => 'Via Roma', 'street_number' => '123', 'locality' => 'Milano',
            'postal_code' => '20100',
        ]);
        $model2 = HasAddressTestModel::create(['name' => 'Model 2']);
        $model2->addresses()->create([
            'route' => 'Via Garibaldi', 'street_number' => '456', 'locality' => 'Roma',
            'postal_code' => '00100',
        ]);

        $modelsInMilano = HasAddressTestModel::inCity('Milano')->get();
        $modelsInRoma = HasAddressTestModel::inCity('Roma')->get();
        self::assertCount(1, $modelsInMilano);
        self::assertSame('Model 1', $modelsInMilano->first()->name);
        self::assertCount(1, $modelsInRoma);
        self::assertSame('Model 2', $modelsInRoma->first()->name);
    }
}
