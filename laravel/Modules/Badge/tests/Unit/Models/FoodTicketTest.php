<?php

declare(strict_types=1);

use Modules\Badge\Models\BaseModel;
use Modules\Badge\Models\FoodTicket;

test('food ticket model exists', function () {
    expect(class_exists(FoodTicket::class))->toBeTrue();
});

test('food ticket has fillable attributes', function () {
    $foodTicket = new FoodTicket;

    expect($foodTicket->getFillable())
        ->toBeArray()
        ->toContain('id');
});

test('food ticket extends base model', function () {
    $foodTicket = new FoodTicket;

    expect($foodTicket)
        ->toBeInstanceOf(BaseModel::class);
});
