<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('base model extends eloquent model', function () {
    $baseModel = new class extends BaseModel {
        protected $table = 'test_geo_table';
    };

    Assert::assertInstanceOf(Model::class, $baseModel);
});

test('base model has correct table name', function () {
    $baseModel = new class extends BaseModel {
        protected $table = 'test_geo_table';
    };

    Assert::assertSame('test_geo_table', $baseModel->getTable());
});

test('base model can be instantiated', function () {
    $baseModel = new class extends BaseModel {
        protected $table = 'test_geo_table';
    };

    Assert::assertInstanceOf(BaseModel::class, $baseModel);
});

test('base model has proper inheritance chain', function () {
    $baseModel = new class extends BaseModel {
        protected $table = 'test_geo_table';
    };

    Assert::assertInstanceOf(BaseModel::class, $baseModel);
    Assert::assertInstanceOf(Model::class, $baseModel);
});

test('base model has timestamps enabled', function () {
    $baseModel = new class extends BaseModel {
        protected $table = 'test_geo_table';
    };

    Assert::assertTrue($baseModel->usesTimestamps());
=======
uses(\Modules\Geo\Tests\TestCase::class);

use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Models\BaseModel;

beforeEach(function () {
    $this->baseModel = new class extends BaseModel {
        protected $table = 'test_geo_table';
    };
});

test('base model extends eloquent model', function () {
    expect($this->baseModel)->toBeInstanceOf(Model::class);
});

test('base model has correct table name', function () {
    expect($this->baseModel->getTable())->toBe('test_geo_table');
});

test('base model can be instantiated', function () {
    expect($this->baseModel)->toBeInstanceOf(BaseModel::class);
});

test('base model has proper inheritance chain', function () {
    expect($this->baseModel)->toBeInstanceOf(BaseModel::class);
    expect($this->baseModel)->toBeInstanceOf(Model::class);
});

test('base model has timestamps enabled', function () {
    expect($this->baseModel->usesTimestamps())->toBeTrue();
>>>>>>> laraxot/dev
});
