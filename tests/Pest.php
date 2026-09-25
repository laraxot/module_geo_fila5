<?php

declare(strict_types=1);

use Modules\Geo\Database\Factories\ComuneFactory;
use Modules\Geo\Database\Factories\RegionFactory;
use Modules\Geo\Models\Comune;
use Modules\Geo\Models\Region;
<<<<<<< HEAD
use Modules\Geo\Tests\TestCase;

/*
 * Bootstrap Pest — modulo Geo.
 * `pest()->extend(TestCase::class)->in(...)` è la forma **consigliata** (XOT-5.41).
 * Non duplicare `uses(TestCase::class)` nei file: XOR → TestCaseAlreadyInUse.
 */

/**
 * @param  array<string, mixed>  $attributes
=======

/*
 * Bootstrap Pest — modulo Geo.
 * Ogni file test dichiara uses(\Modules\Geo\Tests\TestCase::class) o LightTestCase/UnitTestCase FQCN.
 * Vietato uses()->in() qui (PHPStan method.internalClass).
 */

/*
 * |--------------------------------------------------------------------------
 * | Functions
 * |--------------------------------------------------------------------------
 */

/**
 * @param array<string, mixed> $attributes
>>>>>>> laraxot/dev
 */
function createRegion(array $attributes = []): Region
{
    return RegionFactory::new()->createOne($attributes);
}

/**
<<<<<<< HEAD
 * @param  array<string, mixed>  $attributes
=======
 * @param array<string, mixed> $attributes
>>>>>>> laraxot/dev
 */
function createComune(array $attributes = []): Comune
{
    return ComuneFactory::new()->createOne($attributes);
}
<<<<<<< HEAD

pest()->extend(TestCase::class)->in(__DIR__.'/Unit', __DIR__.'/Feature');
=======
>>>>>>> laraxot/dev
