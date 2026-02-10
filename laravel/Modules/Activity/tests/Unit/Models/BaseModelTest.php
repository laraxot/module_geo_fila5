<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Models\BaseModel;

test('BaseModel has correct connection', function () {
<<<<<<< HEAD
    $model = new class extends BaseModel {
=======
    $model = new class() extends BaseModel
    {
>>>>>>> ac0ea089 (.)
        protected $table = 'test_models';

        protected $fillable = ['name'];
    };
    $reflection = new \ReflectionClass($model);
    $property = $reflection->getProperty('connection');
    $property->setAccessible(true);

    expect($property->getValue($model))->toBe('activity');
});

test('BaseModel extends XotBaseModel', function () {
<<<<<<< HEAD
    $model = new class extends BaseModel {
=======
    $model = new class() extends BaseModel
    {
>>>>>>> ac0ea089 (.)
        protected $table = 'test_models';

        protected $fillable = ['name'];
    };

    expect($model)->toBeInstanceOf(\Modules\Xot\Models\XotBaseModel::class);
});
