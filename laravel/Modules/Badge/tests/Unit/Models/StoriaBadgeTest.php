<?php

declare(strict_types=1);

use Modules\Badge\Models\BaseModel;
use Modules\Badge\Models\StoriaBadge;

test('storia badge model exists', function () {
    expect(class_exists(StoriaBadge::class))->toBeTrue();
});

test('storia badge has fillable attributes', function () {
    $storiaBadge = new StoriaBadge;

    expect($storiaBadge->getFillable())
        ->toBeArray()
        ->toContain('id');
});

test('storia badge extends base model', function () {
    $storiaBadge = new StoriaBadge;

    expect($storiaBadge)
        ->toBeInstanceOf(BaseModel::class);
});
