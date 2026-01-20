<?php

declare(strict_types=1);

namespace Modules\Badge\Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Badge\Models\FoodTicket;
use Modules\Badge\Models\Halley;
use Modules\Badge\Models\Mensa;
use Modules\Badge\Models\Mylog;
use Modules\Badge\Models\StoriaBadge;
use Modules\Badge\Models\Timbra;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

uses(TestCase::class)
    ->uses(DatabaseTransactions::class)
    ->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeTimbra', fn () => $this->toBeInstanceOf(Timbra::class));

expect()->extend('toBeFoodTicket', fn () => $this->toBeInstanceOf(FoodTicket::class));

expect()->extend('toBeMensa', fn () => $this->toBeInstanceOf(Mensa::class));

expect()->extend('toBeMylog', fn () => $this->toBeInstanceOf(Mylog::class));

expect()->extend('toBeHalley', fn () => $this->toBeInstanceOf(Halley::class));

expect()->extend('toBeStoriaBadge', fn () => $this->toBeInstanceOf(StoriaBadge::class));

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function createTimbra(array $attributes = []): Timbra
{
    return Timbra::factory()->create($attributes);
}

function makeTimbra(array $attributes = []): Timbra
{
    return Timbra::factory()->make($attributes);
}

function createFoodTicket(array $attributes = []): FoodTicket
{
    return FoodTicket::factory()->create($attributes);
}

function makeFoodTicket(array $attributes = []): FoodTicket
{
    return FoodTicket::factory()->make($attributes);
}

function createMensa(array $attributes = []): Mensa
{
    return Mensa::factory()->create($attributes);
}

function makeMensa(array $attributes = []): Mensa
{
    return Mensa::factory()->make($attributes);
}

function createMylog(array $attributes = []): Mylog
{
    return Mylog::factory()->create($attributes);
}

function makeMylog(array $attributes = []): Mylog
{
    return Mylog::factory()->make($attributes);
}

function createHalley(array $attributes = []): Halley
{
    return Halley::factory()->create($attributes);
}

function makeHalley(array $attributes = []): Halley
{
    return Halley::factory()->make($attributes);
}

function createStoriaBadge(array $attributes = []): StoriaBadge
{
    return StoriaBadge::factory()->create($attributes);
}

function makeStoriaBadge(array $attributes = []): StoriaBadge
{
    return StoriaBadge::factory()->make($attributes);
}
