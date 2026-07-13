<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Builder;
<<<<<<< HEAD
use Modules\Geo\Database\Factories\RegionFactory;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Region;
use Modules\Xot\Models\Traits\HasXotFactory;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

use Sushi\Sushi;

uses(\Modules\Geo\Tests\TestCase::class);
describe('Region Business Logic', function () {
    test('region extends base model', function () {
        Assert::assertInstanceOf(BaseModel::class, new Region());
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Geo\Database\Factories\RegionFactory;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Region;
use Sushi\Sushi;

describe('Region Business Logic', function () {
    test('region extends base model', function () {
        expect(Region::class)->toBeSubclassOf(BaseModel::class);
>>>>>>> laraxot/dev
    });

    test('region has factory trait for testing', function () {
        $traits = class_uses(Region::class);

<<<<<<< HEAD
        Assert::assertArrayHasKey(HasXotFactory::class, $traits);
=======
        expect($traits)->toHaveKey(HasFactory::class);
>>>>>>> laraxot/dev
    });

    test('region uses sushi trait for in-memory data', function () {
        $traits = class_uses(Region::class);

<<<<<<< HEAD
        Assert::assertArrayHasKey(Sushi::class, $traits);
=======
        expect($traits)->toHaveKey(Sushi::class);
>>>>>>> laraxot/dev
    });

    test('region has correct key type configured', function () {
        $region = new Region();

<<<<<<< HEAD
        Assert::assertSame('integer', $region->getKeyType());
=======
        expect($region->getKeyType())->toBe('integer');
>>>>>>> laraxot/dev
    });

    test('region has schema definition for geographic data', function () {
        $region = new Region();
<<<<<<< HEAD
        $reflection = new \ReflectionClass($region);
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        $schema = $schemaProperty->getValue($region);
        Assert::assertIsArray($schema);
        /* @var array<string, mixed> $schema */
        Assert::assertSame('integer', $schema['id']);
        Assert::assertSame('string', $schema['name']);
    });

    test('region can be created via factory', function () {
        $region = RegionFactory::new()->createOne();

        Assert::assertInstanceOf(Region::class, $region);
=======

        expect($region)->toHaveProperty('schema');
        expect($region->schema['id'])->toBe('integer');
        expect($region->schema['name'])->toBe('string');
    });

    test('region has factory class configured', function () {
        expect(Region::$factory)->toBe(RegionFactory::class);
>>>>>>> laraxot/dev
    });

    test('region model can be instantiated without errors', function () {
        $region = new Region();

<<<<<<< HEAD
        Assert::assertInstanceOf(Region::class, $region);
        Assert::assertInstanceOf(BaseModel::class, $region);
=======
        expect($region)->toBeInstanceOf(Region::class);
        expect($region)->toBeInstanceOf(BaseModel::class);
>>>>>>> laraxot/dev
    });

    test('region can be queried by name', function () {
        $query = Region::whereName('Lombardia');

<<<<<<< HEAD
        Assert::assertInstanceOf(Builder::class, $query);
=======
        expect($query)->toBeInstanceOf(Builder::class);
>>>>>>> laraxot/dev
    });

    test('region can be queried by id', function () {
        $query = Region::whereId(1);

<<<<<<< HEAD
        Assert::assertInstanceOf(Builder::class, $query);
=======
        expect($query)->toBeInstanceOf(Builder::class);
>>>>>>> laraxot/dev
    });
});
