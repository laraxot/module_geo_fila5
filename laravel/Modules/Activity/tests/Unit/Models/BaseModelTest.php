<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Models\BaseModel;

function makeTestBaseModel(array $attributes = []): BaseModel
{
    return new class ($attributes) extends BaseModel {
        protected $table = 'test_models';

        protected $fillable = ['name'];
    };
}

test('BaseModel has correct connection', function () {
    $model = makeTestBaseModel();
    $reflection = new \ReflectionClass($model);
    $property = $reflection->getProperty('connection');
    $property->setAccessible(true);

    expect($property->getValue($model))->toBe('activity');
});

test('BaseModel extends XotBaseModel', function () {
    $model = makeTestBaseModel();

    expect($model)->toBeInstanceOf(\Modules\Xot\Models\XotBaseModel::class);
});
