<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Geo\Traits\HandlesCoordinates;
use Tests\TestCase;

// Test model using HandlesCoordinates
class HandlesCoordinatesTestModel
{
    use HandlesCoordinates;

    protected $table = 'handles_coords_test_models';
    protected $guarded = [];
    public $incrementing = false;
    protected $keyType = 'string';
}

uses(TestCase::class, RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    \Illuminate\Support\Facades\Schema::create('handles_coords_test_models', function ($table) {
        $table->string('id')->primary();
        $table->decimal('latitude', 10, 7)->nullable();
        $table->decimal('longitude', 10, 7)->nullable();
        $table->timestamps();
    });
});

afterEach(function () {
    \Illuminate\Support\Facades\Schema::dropIfExists('handles_coords_test_models');
});

describe('HandlesCoordinates Trait', function () {
    it('sets coordinates via setCoordinates method', function () {
        $model = new HandlesCoordinatesTestModel();
        $model->id = 'test-1';
        $model->setCoordinates(45.4642, 9.1900);
        $model->save();

        expect($model->latitude)->toBe(45.4642);
        expect($model->longitude)->toBe(9.1900);
    });

    it('gets coordinates via getCoordinates method', function () {
        $model = new HandlesCoordinatesTestModel();
        $model->id = 'test-1';
        $model->latitude = 41.9028;
        $model->longitude = 12.4964;
        $model->save();

        $coords = $model->getCoordinates();

        expect($coords)->toBeArray()
            ->toHaveKeys(['latitude', 'longitude']);
        expect($coords['latitude'])->toBe(41.9028);
        expect($coords['longitude'])->toBe(12.4964);
    });

    it('returns null for missing coordinates', function () {
        $model = new HandlesCoordinatesTestModel();
        $model->id = 'test-1';
        $model->save();

        $coords = $model->getCoordinates();

        expect($coords['latitude'])->toBeNull();
        expect($coords['longitude'])->toBeNull();
    });

    it('checks if has coordinates', function () {
        $modelWithCoords = new HandlesCoordinatesTestModel();
        $modelWithCoords->id = 'test-1';
        $modelWithCoords->latitude = 45.0;
        $modelWithCoords->longitude = 9.0;
        $modelWithCoords->save();

        $modelWithoutCoords = new HandlesCoordinatesTestModel();
        $modelWithoutCoords->id = 'test-2';
        $modelWithoutCoords->save();

        expect($modelWithCoords->hasCoordinates())->toBeTrue();
        expect($modelWithoutCoords->hasCoordinates())->toBeFalse();
    });

    it('calculates distance to another model', function () {
        $model1 = new HandlesCoordinatesTestModel();
        $model1->id = 'test-1';
        $model1->latitude = 45.4642; // Milano
        $model1->longitude = 9.1900;
        $model1->save();

        $model2 = new HandlesCoordinatesTestModel();
        $model2->id = 'test-2';
        $model2->latitude = 41.9028; // Roma
        $model2->longitude = 12.4964;
        $model2->save();

        $distance = $model1->distanceTo($model2);

        expect($distance)->toBeFloat()->toBeGreaterThan(0);
        // Milano to Roma ~ 477 km
        expect($distance)->toBeGreaterThan(400000); // meters
        expect($distance)->toBeLessThan(600000);
    });

    it('returns null distance if either model lacks coordinates', function () {
        $modelWithCoords = new HandlesCoordinatesTestModel();
        $modelWithCoords->id = 'test-1';
        $modelWithCoords->latitude = 45.0;
        $modelWithCoords->longitude = 9.0;
        $modelWithCoords->save();

        $modelWithoutCoords = new HandlesCoordinatesTestModel();
        $modelWithoutCoords->id = 'test-2';
        $modelWithoutCoords->save();

        $distance = $modelWithCoords->distanceTo($modelWithoutCoords);

        expect($distance)->toBeNull();
    });

    it('validates coordinate ranges', function () {
        $model = new HandlesCoordinatesTestModel();
        $model->id = 'test-1';

        // Valid coordinates
        $model->setCoordinates(45.0, 9.0);
        expect($model->latitude)->toBe(45.0);
        expect($model->longitude)->toBe(9.0);

        // Edge cases
        $model->setCoordinates(-90, -180);
        expect($model->latitude)->toBe(-90);
        expect($model->longitude)->toBe(-180);

        $model->setCoordinates(90, 180);
        expect($model->latitude)->toBe(90);
        expect($model->longitude)->toBe(180);
    });
});