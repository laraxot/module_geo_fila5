<?php

declare(strict_types=1);

<<<<<<< HEAD
use Modules\Geo\Database\Factories\ComuneFactory;
use Modules\Geo\Database\Factories\RegionFactory;
use Modules\Geo\Models\Comune;
use Modules\Geo\Models\Region;

/*
 * Bootstrap Pest — modulo Geo.
 * Ogni file test dichiara uses(\Modules\Geo\Tests\TestCase::class) o LightTestCase/UnitTestCase FQCN.
 * Vietato uses()->in() qui (PHPStan method.internalClass).
 */

=======
use Modules\Geo\Models\City;
use Modules\Geo\Models\Country;
use Modules\Geo\Models\Region;
use Modules\Geo\Tests\TestCase;

/*
 * |--------------------------------------------------------------------------
 * | Test Case
 * |--------------------------------------------------------------------------
 * |
 * | The closure you provide to your test functions is always bound to a specific PHPUnit test
 * | case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
 * | need to change it using the "pest()" function to bind a different classes or traits.
 * |
 */

pest()->extend(TestCase::class)->in('Feature', 'Unit');

/*
 * |--------------------------------------------------------------------------
 * | Expectations
 * |--------------------------------------------------------------------------
 * |
 * | When you're writing tests, you often need to check that values meet certain conditions. The
 * | "expect()" function gives you access to a set of "expectations" methods that you can use
 * | to assert different things. Of course, you may extend the Expectation API at any time.
 * |
 */

expect()->extend('toBeCountry', fn () => $this->toBeInstanceOf(Country::class));

expect()->extend('toBeRegion', fn () => $this->toBeInstanceOf(Region::class));

expect()->extend('toBeCity', fn () => $this->toBeInstanceOf(City::class));

>>>>>>> laraxot/dev
/*
 * |--------------------------------------------------------------------------
 * | Functions
 * |--------------------------------------------------------------------------
<<<<<<< HEAD
 */

/**
 * @param array<string, mixed> $attributes
 */
function createRegion(array $attributes = []): Region
{
    return RegionFactory::new()->createOne($attributes);
}

/**
 * @param array<string, mixed> $attributes
 */
function createComune(array $attributes = []): Comune
{
    return ComuneFactory::new()->createOne($attributes);
=======
 * |
 * | While Pest is very powerful out-of-the-box, you may have some testing code specific to your
 * | project that you don't want to repeat in every file. Here you can also expose helpers as
 * | global functions to help you to reduce the number of lines of code in your test files.
 * |
 */

function createCountry(array $attributes = []): Country
{
    return Country::factory()->create($attributes);
}

function createRegion(array $attributes = []): Region
{
    return Region::factory()->create($attributes);
}

function createCity(array $attributes = []): City
{
    return City::factory()->create($attributes);
>>>>>>> laraxot/dev
}
