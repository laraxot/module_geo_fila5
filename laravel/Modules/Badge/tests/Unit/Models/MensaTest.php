<?php

declare(strict_types=1);

use Modules\Badge\Models\BaseModel;
use Modules\Badge\Models\Mensa;

test('mensa model exists', function () {
    expect(class_exists(Mensa::class))->toBeTrue();
});

test('mensa has fillable attributes', function () {
    $mensa = new Mensa;

    expect($mensa->getFillable())
        ->toBeArray()
        ->toContain('id');
});

test('mensa extends base model', function () {
    $mensa = new Mensa;

    expect($mensa)
        ->toBeInstanceOf(BaseModel::class);
});
