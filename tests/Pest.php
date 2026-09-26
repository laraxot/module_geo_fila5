<?php

declare(strict_types=1);
<<<<<<< .merge_file_Kg2zMI
=======

>>>>>>> .merge_file_r5OayK
use Modules\Geo\Database\Factories\ComuneFactory;
use Modules\Geo\Database\Factories\RegionFactory;
use Modules\Geo\Models\Comune;
use Modules\Geo\Models\Region;
<<<<<<< .merge_file_Kg2zMI
use Modules\Geo\Tests\TestCase;

/*
 * Bootstrap Pest — modulo Geo.
 * `pest()->extend(TestCase::class)->in(...)` è la forma **consigliata** (XOT-5.41).
 * Non duplicare `uses(TestCase::class)` nei file: XOR → TestCaseAlreadyInUse.
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
>>>>>>> .merge_file_r5OayK
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
}
<<<<<<< .merge_file_Kg2zMI

pest()->extend(TestCase::class)->in(__DIR__.'/Unit', __DIR__.'/Feature');
=======
>>>>>>> .merge_file_r5OayK
