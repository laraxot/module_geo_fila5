<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Tests\Fixtures\TestBaseModel;

test('BaseModel has correct connection', function () {
    $model = new TestBaseModel();
    $reflection = new \ReflectionClass($model);
    $property = $reflection->getProperty('connection');
    $property->setAccessible(true);

    expect($property->getValue($model))->toBe('activity');
});

test('BaseModel extends XotBaseModel', function () {
    $model = new TestBaseModel();

    expect($model)->toBeInstanceOf(\Modules\Xot\Models\XotBaseModel::class);
});
