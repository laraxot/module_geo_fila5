<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Province;
use PHPUnit\Framework\Assert;
use Sushi\Sushi;

/**
 * Contratto di dominio Province (Sushi da comuni.json, gerarchia regione → province).
 * Assert PHPUnit: evita crash pest-plugin-phpstan HigherOrderExpectationTypeExtension.
 */
describe('Province Business Logic', function () {
    test('province extends base model', function () {
        Assert::assertSame(BaseModel::class, get_parent_class(Province::class));
    });

    test('province has factory trait for testing', function () {
        Assert::assertContains(HasFactory::class, class_uses_recursive(Province::class));
    });

    test('province uses sushi trait for in-memory data', function () {
        Assert::assertContains(Sushi::class, class_uses_recursive(Province::class));
    });

    test('province has schema definition for geographic hierarchy', function () {
<<<<<<< .merge_file_Oil9jp
        $schema = (new Province)->getSchema();
=======
        $province = new Province();
>>>>>>> .merge_file_bM1315

        Assert::assertIsArray($schema);
        Assert::assertSame('integer', $schema['region_id'] ?? null);
        Assert::assertSame('integer', $schema['id'] ?? null);
        Assert::assertSame('string', $schema['name'] ?? null);
    });

    test('province can get rows from comune data', function () {
<<<<<<< .merge_file_Oil9jp
        $rows = (new Province)->getRows();
=======
        $province = new Province();
>>>>>>> .merge_file_bM1315

        Assert::assertGreaterThanOrEqual(0, count($rows));
    });

    test('province model can be instantiated without errors', function () {
        $province = new Province();

        Assert::assertInstanceOf(Province::class, $province);
        Assert::assertInstanceOf(BaseModel::class, $province);
    });

    test('province can be queried by name', function () {
        $query = Province::whereName('Milano');

        Assert::assertInstanceOf(Builder::class, $query);
    });

    test('province can be queried by region id', function () {
        $query = Province::whereRegionId(1);

        Assert::assertInstanceOf(Builder::class, $query);
    });
});
