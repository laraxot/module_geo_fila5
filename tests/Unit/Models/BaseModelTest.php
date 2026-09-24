<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Models\BaseModel;
use PHPUnit\Framework\Assert;

test('base model extends eloquent model', function () {
<<<<<<< HEAD
    $baseModel = new class() extends BaseModel
    {
=======
    $baseModel = new class extends BaseModel {
>>>>>>> laraxot/dev
        protected $table = 'test_geo_table';
    };

    Assert::assertInstanceOf(Model::class, $baseModel);
});

test('base model has correct table name', function () {
<<<<<<< HEAD
    $baseModel = new class() extends BaseModel
    {
=======
    $baseModel = new class extends BaseModel {
>>>>>>> laraxot/dev
        protected $table = 'test_geo_table';
    };

    Assert::assertSame('test_geo_table', $baseModel->getTable());
});

test('base model can be instantiated', function () {
<<<<<<< HEAD
    $baseModel = new class() extends BaseModel
    {
=======
    $baseModel = new class extends BaseModel {
>>>>>>> laraxot/dev
        protected $table = 'test_geo_table';
    };

    Assert::assertInstanceOf(BaseModel::class, $baseModel);
});

test('base model has proper inheritance chain', function () {
<<<<<<< HEAD
    $baseModel = new class() extends BaseModel
    {
=======
    $baseModel = new class extends BaseModel {
>>>>>>> laraxot/dev
        protected $table = 'test_geo_table';
    };

    Assert::assertInstanceOf(BaseModel::class, $baseModel);
    Assert::assertInstanceOf(Model::class, $baseModel);
});

test('base model has timestamps enabled', function () {
<<<<<<< HEAD
    $baseModel = new class() extends BaseModel
    {
=======
    $baseModel = new class extends BaseModel {
>>>>>>> laraxot/dev
        protected $table = 'test_geo_table';
    };

    Assert::assertTrue($baseModel->usesTimestamps());
});
