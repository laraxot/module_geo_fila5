<?php

declare(strict_types=1);

use Modules\Badge\Models\BaseModel;
use Modules\Badge\Models\Timbra;

test('timbra model exists', function () {
    expect(class_exists(Timbra::class))->toBeTrue();
});

test('timbra has fillable attributes', function () {
    $timbra = new Timbra;

    expect($timbra->getFillable())
        ->toBeArray()
        ->toContain('id');
});

test('timbra extends base model', function () {
    $timbra = new Timbra;

    expect($timbra)
        ->toBeInstanceOf(BaseModel::class);
});
