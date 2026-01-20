<?php

declare(strict_types=1);

use Modules\Badge\Models\BaseModel;
use Modules\Badge\Models\Mylog;

test('mylog model exists', function () {
    expect(class_exists(Mylog::class))->toBeTrue();
});

test('mylog has fillable attributes', function () {
    $mylog = new Mylog;

    expect($mylog->getFillable())
        ->toBeArray()
        ->toContain('id');
});

test('mylog extends base model', function () {
    $mylog = new Mylog;

    expect($mylog)
        ->toBeInstanceOf(BaseModel::class);
});
