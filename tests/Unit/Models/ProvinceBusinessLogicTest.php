<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Builder;
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
    });

    test('province has factory trait for testing', function () {
        $traits = class_uses(Province::class);

<<<<<<< HEAD
       Assert::assertArrayHasKey(HasXotFactory::class, $traits);
=======
        Assert::assertArrayHasKey(HasXotFactory::class, $traits);
>>>>>>> laraxot/dev
    });

    test('province uses sushi trait for in-memory data', function () {
        $traits = class_uses(Province::class);

<<<<<<< HEAD
       Assert::assertArrayHasKey(Sushi::class, $traits);
=======
        Assert::assertArrayHasKey(Sushi::class, $traits);
>>>>>>> laraxot/dev
    });

    test('province has schema definition for geographic hierarchy', function () {
        $province = new Province();
<<<<<<< HEAD
       $reflection = new \ReflectionClass($province);
=======
        $reflection = new \ReflectionClass($province);
>>>>>>> laraxot/dev
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        $schema = $schemaProperty->getValue($province);
        Assert::assertIsArray($schema);
        /* @var array<string, mixed> $schema */
        Assert::assertSame('integer', $schema['region_id']);
        Assert::assertSame('integer', $schema['id']);
        Assert::assertSame('string', $schema['name']);
    });

    test('province can get rows from comune data', function () {
        $province = new Province();
<<<<<<< HEAD
       $rows = $province->getRows();
=======
        $rows = $province->getRows();
>>>>>>> laraxot/dev

        Assert::assertNotEmpty($rows);
    });

    test('province model can be instantiated without errors', function () {
        $province = new Province();

<<<<<<< HEAD
       Assert::assertInstanceOf(Province::class, $province);
=======
        Assert::assertInstanceOf(Province::class, $province);
>>>>>>> laraxot/dev
        Assert::assertInstanceOf(BaseModel::class, $province);
    });

    test('province can be queried by name', function () {
        $query = Province::whereName('Milano');

<<<<<<< HEAD
       Assert::assertInstanceOf(Builder::class, $query);
=======
        Assert::assertInstanceOf(Builder::class, $query);
>>>>>>> laraxot/dev
    });

    test('province can be queried by region id', function () {
        $query = Province::whereRegionId(1);

<<<<<<< HEAD
       Assert::assertInstanceOf(Builder::class, $query);
=======
        Assert::assertInstanceOf(Builder::class, $query);
>>>>>>> laraxot/dev
    });
});
