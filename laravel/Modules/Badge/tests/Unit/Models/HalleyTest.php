<?php

declare(strict_types=1);

use Modules\Badge\Models\BaseModel;
use Modules\Badge\Models\Halley;

test('halley model exists', function () {
    expect(class_exists(Halley::class))->toBeTrue();
});

test('halley has fillable attributes', function () {
    $halley = new Halley;

    expect($halley->getFillable())
        ->toBeArray()
        ->toContain('id');
});

test('halley extends base model', function () {
    $halley = new Halley;

    expect($halley)
        ->toBeInstanceOf(BaseModel::class);
});
