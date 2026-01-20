<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Ptv\Models\Profile;
use Tests\TestCase;

uses(
    TestCase::class,
    DatabaseTransactions::class, // ✅ CORRETTO - Rollback automatico
    WithFaker::class,
)->in('Feature', 'Unit');

uses()->group('ptv')->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Custom Expectations
|--------------------------------------------------------------------------
|
| Here you may define your custom expectations to be used in your tests.
|
*/

expect()->extend('toBeProfile', fn () => $this->toBeInstanceOf(Profile::class));

expect()->extend('toHaveProperty', fn (string $property) => expect(isset($this->value->$property))->toBeTrue());

/*
|--------------------------------------------------------------------------
| Helper Functions
|--------------------------------------------------------------------------
|
| Here you may define your custom helper functions to be used in your tests.
|
*/

function createProfile(array $attributes = []): Profile
{
    return Profile::factory()->create($attributes);
}

function makeProfile(array $attributes = []): Profile
{
    return Profile::factory()->make($attributes);
}
