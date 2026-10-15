<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Geo\Models\Region;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class, WithFaker::class);

describe('Region Model', function () {
    it('creates a region with required fields', function () {
        $region = Region::create([
            'name' => 'Lombardia',
            'code' => '03',
        ]);

        expect($region)->toBeInstanceOf(Region::class);
        expect($region->name)->toBe('Lombardia');
        expect($region->code)->toBe('03');
    });

    it('has fillable fields', function () {
        $fillable = (new Region())->getFillable();

        expect($fillable)->toContain('name');
        expect($fillable)->toContain('code');
    });

    it('has many provinces', function () {
        $region = Region::factory()->create();

        expect($region->provinces())->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\HasMany::class);
    });

    it('code is unique', function () {
        Region::factory()->create(['code' => '03', 'name' => 'Lombardia']);

        expect(fn () => Region::factory()->create(['code' => '03', 'name' => 'Lombardia 2']))
            ->toThrow(\Illuminate\Database\QueryException::class);
    });
});