<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Traits;

use Modules\Geo\Tests\Fixtures\Traits\HasAddressTestModel;

beforeEach(function (): void {
    $this->model = new HasAddressTestModel();
    $this->model->name = 'Test Model';
    $this->model->save();
});

it('can have multiple addresses', function (): void {
    $this->model
        ->addresses()
        ->create([
            'route' => 'Via Roma',
            'street_number' => '123',
            'locality' => 'Milano',
            'postal_code' => '20100',
            'is_primary' => true,
        ]);

    $this->model
        ->addresses()
        ->create([
            'route' => 'Via Garibaldi',
            'street_number' => '456',
            'locality' => 'Roma',
            'postal_code' => '00100',
            'is_primary' => false,
        ]);

    expect($this->model->addresses)->toHaveCount(2);
});

it('can get primary address', function (): void {
    $this->model
        ->addresses()
        ->create([
            'route' => 'Via Roma',
            'street_number' => '123',
            'locality' => 'Milano',
            'postal_code' => '20100',
            'is_primary' => true,
        ]);

    $this->model
        ->addresses()
        ->create([
            'route' => 'Via Garibaldi',
            'street_number' => '456',
            'locality' => 'Roma',
            'postal_code' => '00100',
            'is_primary' => false,
        ]);

    $primaryAddress = $this->model->primaryAddress();

    expect($primaryAddress)->not->toBeNull();
    expect($primaryAddress->route)->toBe('Via Roma');
});

it('can set primary address', function (): void {
    $address1 = $this->model
        ->addresses()
        ->create([
            'route' => 'Via Roma',
            'street_number' => '123',
            'locality' => 'Milano',
            'postal_code' => '20100',
            'is_primary' => true,
        ]);

    $address2 = $this->model
        ->addresses()
        ->create([
            'route' => 'Via Garibaldi',
            'street_number' => '456',
            'locality' => 'Roma',
            'postal_code' => '00100',
            'is_primary' => false,
        ]);

    $this->model->setAsPrimaryAddress($address2);

    $address1->refresh();
    $address2->refresh();

    expect($address1->is_primary)->toBeFalse();
    expect($address2->is_primary)->toBeTrue();
});

it('can get formatted address', function (): void {
    $this->model
        ->addresses()
        ->create([
            'route' => 'Via Roma',
            'street_number' => '123',
            'locality' => 'Milano',
            'postal_code' => '20100',
            'is_primary' => true,
        ]);

    $fullAddress = $this->model->getFullAddress();

    expect($fullAddress)->not->toBeNull();
    expect($fullAddress)->toContain('Via Roma');
    expect($fullAddress)->toContain('Milano');
});

it('can filter models by city', function (): void {
    $model1 = new HasAddressTestModel();
    $model1->name = 'Model 1';
    $model1->save();

    $model1
        ->addresses()
        ->create([
            'route' => 'Via Roma',
            'street_number' => '123',
            'locality' => 'Milano',
            'postal_code' => '20100',
        ]);

    $model2 = new HasAddressTestModel();
    $model2->name = 'Model 2';
    $model2->save();

    $model2
        ->addresses()
        ->create([
            'route' => 'Via Garibaldi',
            'street_number' => '456',
            'locality' => 'Roma',
            'postal_code' => '00100',
        ]);

    $modelsInMilano = HasAddressTestModel::inCity('Milano')->get();
    $modelsInRoma = HasAddressTestModel::inCity('Roma')->get();

    expect($modelsInMilano)->toHaveCount(1);
    expect($modelsInMilano->first()->name)->toBe('Model 1');

    expect($modelsInRoma)->toHaveCount(1);
    expect($modelsInRoma->first()->name)->toBe('Model 2');
});
