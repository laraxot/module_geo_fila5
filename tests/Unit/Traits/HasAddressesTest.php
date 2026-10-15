<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Geo\Traits\HasAddresses;
use Tests\TestCase;

// Test model using HasAddresses
class HasAddressesTestModel
{
    use HasAddresses;

    protected $table = 'has_addresses_test_models';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
}

uses(TestCase::class, RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    \Illuminate\Support\Facades\Schema::create('has_addresses_test_models', function ($table) {
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
    \Illuminate\Support\Facades\Schema::dropIfExists('has_addresses_test_models');
});

describe('HasAddresses Trait', function () {
    it('provides addresses morphMany relationship', function () {
        $model = new HasAddressesTestModel();
        $model->id = 'test-1';
        $model->save();

        expect($model->addresses())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphMany::class);
    });

    it('provides primaryAddress morphOne relationship', function () {
        $model = new HasAddressesTestModel();
        $model->id = 'test-1';
        $model->save();

        expect($model->primaryAddress())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\MorphOne::class);
    });

    it('allows creating multiple addresses', function () {
        $model = new HasAddressesTestModel();
        $model->id = 'test-1';
        $model->save();

        $model->addresses()->create([
            'type' => 'billing',
            'street' => 'Via Roma 1',
            'city' => 'Milano',
            'province' => 'MI',
            'postal_code' => '20100',
        ]);

        $model->addresses()->create([
            'type' => 'shipping',
            'street' => 'Via Milano 10',
            'city' => 'Roma',
            'province' => 'RM',
            'postal_code' => '00100',
        ]);

        expect($model->addresses()->count())->toBe(2);
    });

    it('sets only one primary address', function () {
        $model = new HasAddressesTestModel();
        $model->id = 'test-1';
        $model->save();

        $addr1 = $model->addresses()->create([
            'type' => 'billing',
            'street' => 'Via Uno',
            'city' => 'Milano',
            'is_primary' => true,
        ]);

        $addr2 = $model->addresses()->create([
            'type' => 'shipping',
            'street' => 'Via Due',
            'city' => 'Roma',
            'is_primary' => true, // This should become primary
        ]);

        // Refresh to get updated primary
        $model->refresh();
        expect($model->primaryAddress->id)->toBe($addr2->id);
        expect($addr1->fresh()->is_primary)->toBeFalse();
    });

    it('gets address by type', function () {
        $model = new HasAddressesTestModel();
        $model->id = 'test-1';
        $model->save();

        $model->addresses()->create([
            'type' => 'billing',
            'street' => 'Via Billing',
            'city' => 'Milano',
        ]);

        $model->addresses()->create([
            'type' => 'shipping',
            'street' => 'Via Shipping',
            'city' => 'Roma',
        ]);

        $billing = $model->addresses()->where('type', 'billing')->first();
        $shipping = $model->addresses()->where('type', 'shipping')->first();

        expect($billing->street)->toBe('Via Billing');
        expect($shipping->street)->toBe('Via Shipping');
    });
});