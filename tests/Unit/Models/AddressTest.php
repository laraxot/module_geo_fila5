<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Geo\Models\Address;
use Modules\Geo\Traits\HasAddresses;
use Tests\TestCase;

// Create a test model that uses HasAddresses
class AddressTestModel
{
    use HasAddresses;

    protected $table = 'test_models';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
}

uses(TestCase::class, RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    // Create the test table
    \Illuminate\Support\Facades\Schema::create('test_models', function ($table) {
        $table->string('id')->primary();
        $table->timestamps();
    });

    \Illuminate\Support\Facades\Schema::create('addresses', function ($table) {
        $table->id();
        $table->morphs('addressable');
        $table->string('type')->default('default');
        $table->string('street')->nullable();
        $table->string('city')->nullable();
        $table->string('province')->nullable();
        $table->string('postal_code')->nullable();
        $table->string('country')->default('Italia');
        $table->decimal('latitude', 10, 7)->nullable();
        $table->decimal('longitude', 10, 7)->nullable();
        $table->boolean('is_primary')->default(false);
        $table->timestamps();
    });
});

afterEach(function () {
    \Illuminate\Support\Facades\Schema::dropIfExists('addresses');
    \Illuminate\Support\Facades\Schema::dropIfExists('test_models');
});

describe('Address Model', function () {
    it('creates an address with required fields', function () {
        $address = Address::create([
            'addressable_type' => AddressTestModel::class,
            'addressable_id' => 'test-1',
            'type' => 'billing',
            'street' => 'Via Roma 1',
            'city' => 'Milano',
            'province' => 'MI',
            'postal_code' => '20100',
            'country' => 'Italia',
            'latitude' => 45.4642,
            'longitude' => 9.1900,
            'is_primary' => true,
        ]);

        expect($address)->toBeInstanceOf(Address::class);
        expect($address->street)->toBe('Via Roma 1');
        expect($address->city)->toBe('Milano');
        expect($address->is_primary)->toBeTrue();
    });

    it('has fillable fields', function () {
        $fillable = (new Address())->getFillable();

        expect($fillable)->toContain('addressable_type');
        expect($fillable)->toContain('addressable_id');
        expect($fillable)->toContain('type');
        expect($fillable)->toContain('street');
        expect($fillable)->toContain('city');
        expect($fillable)->toContain('province');
        expect($fillable)->toContain('postal_code');
        expect($fillable)->toContain('country');
        expect($fillable)->toContain('latitude');
        expect($fillable)->toContain('longitude');
        expect($fillable)->toContain('is_primary');
    });

    it('morphs to addressable', function () {
        $address = Address::factory()->create();

        expect($address->addressable())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphTo::class);
    });
});

describe('HasAddresses Trait', function () {
    it('provides addresses relationship', function () {
        $model = new AddressTestModel();
        $model->id = 'test-1';
        $model->save();

        expect($model->addresses())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphMany::class);
    });

    it('provides primaryAddress relationship', function () {
        $model = new AddressTestModel();
        $model->id = 'test-1';
        $model->save();

        expect($model->primaryAddress())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphOne::class);
    });

    it('creates address via addresses() relationship', function () {
        $model = new AddressTestModel();
        $model->id = 'test-1';
        $model->save();

        $address = $model->addresses()->create([
            'type' => 'shipping',
            'street' => 'Via Test 10',
            'city' => 'Roma',
            'province' => 'RM',
            'postal_code' => '00100',
        ]);

        expect($address->type)->toBe('shipping');
        expect($address->city)->toBe('Roma');
    });

    it('sets primary address', function () {
        $model = new AddressTestModel();
        $model->id = 'test-1';
        $model->save();

        $address1 = $model->addresses()->create([
            'type' => 'billing',
            'street' => 'Via Uno 1',
            'city' => 'Milano',
            'is_primary' => true,
        ]);

        $address2 = $model->addresses()->create([
            'type' => 'shipping',
            'street' => 'Via Due 2',
            'city' => 'Roma',
            'is_primary' => false,
        ]);

        expect($model->primaryAddress->id)->toBe($address1->id);
    });
});