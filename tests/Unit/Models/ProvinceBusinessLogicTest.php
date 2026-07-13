<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Builder;
<<<<<<< HEAD
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Province;
use Modules\Xot\Models\Traits\HasXotFactory;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

use Sushi\Sushi;

uses(\Modules\Geo\Tests\TestCase::class);
describe('Province Business Logic', function () {
    test('province extends base model', function () {
        Assert::assertInstanceOf(BaseModel::class, new Province());
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Province;
use Sushi\Sushi;

describe('Province Business Logic', function () {
    test('province extends base model', function () {
        expect(Province::class)->toBeSubclassOf(BaseModel::class);
>>>>>>> laraxot/dev
    });

    test('province has factory trait for testing', function () {
        $traits = class_uses(Province::class);

<<<<<<< HEAD
        Assert::assertArrayHasKey(HasXotFactory::class, $traits);
=======
        expect($traits)->toHaveKey(HasFactory::class);
>>>>>>> laraxot/dev
    });

    test('province uses sushi trait for in-memory data', function () {
        $traits = class_uses(Province::class);

<<<<<<< HEAD
        Assert::assertArrayHasKey(Sushi::class, $traits);
=======
        expect($traits)->toHaveKey(Sushi::class);
>>>>>>> laraxot/dev
    });

    test('province has schema definition for geographic hierarchy', function () {
        $province = new Province();
<<<<<<< HEAD
        $reflection = new \ReflectionClass($province);
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        $schema = $schemaProperty->getValue($province);
        Assert::assertIsArray($schema);
        /* @var array<string, mixed> $schema */
        Assert::assertSame('integer', $schema['region_id']);
        Assert::assertSame('integer', $schema['id']);
        Assert::assertSame('string', $schema['name']);
=======

        expect($province)->toHaveProperty('schema');
        expect($province->schema['region_id'])->toBe('integer');
        expect($province->schema['id'])->toBe('integer');
        expect($province->schema['name'])->toBe('string');
>>>>>>> laraxot/dev
    });

    test('province can get rows from comune data', function () {
        $province = new Province();
<<<<<<< HEAD
        $rows = $province->getRows();

        Assert::assertNotEmpty($rows);
=======

        expect(method_exists($province, 'getRows'))->toBeTrue();
        expect($province->getRows())->toBeArray();
>>>>>>> laraxot/dev
    });

    test('province model can be instantiated without errors', function () {
        $province = new Province();

<<<<<<< HEAD
        Assert::assertInstanceOf(Province::class, $province);
        Assert::assertInstanceOf(BaseModel::class, $province);
=======
        expect($province)->toBeInstanceOf(Province::class);
        expect($province)->toBeInstanceOf(BaseModel::class);
>>>>>>> laraxot/dev
    });

    test('province can be queried by name', function () {
        $query = Province::whereName('Milano');

<<<<<<< HEAD
        Assert::assertInstanceOf(Builder::class, $query);
=======
        expect($query)->toBeInstanceOf(Builder::class);
>>>>>>> laraxot/dev
    });

    test('province can be queried by region id', function () {
        $query = Province::whereRegionId(1);

<<<<<<< HEAD
        Assert::assertInstanceOf(Builder::class, $query);
=======
        expect($query)->toBeInstanceOf(Builder::class);
>>>>>>> laraxot/dev
    });
});
