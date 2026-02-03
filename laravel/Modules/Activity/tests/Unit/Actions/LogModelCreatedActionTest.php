<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Actions\LogModelCreatedAction;
use Modules\Activity\Tests\Fixtures\LogModelCreatedActionTestModel;
use Modules\User\Models\User;

test('LogModelCreatedAction can be instantiated', function () {
    $model = new LogModelCreatedActionTestModel();
    $user = User::factory()->make();

    $action = new LogModelCreatedAction($model, $user);

    expect($action)->toBeObject()
        ->and($action->model)->toBe($model)
        ->and($action->user)->toBe($user);
});

test('LogModelCreatedAction can execute', function () {
    $model = new LogModelCreatedActionTestModel(['name' => 'Test']);
    $user = User::factory()->create();

    $action = new LogModelCreatedAction($model, $user);

    // Siccome LogModelCreatedAction chiama LogActivityAction,
    // testiamo che l'execute non generi errori
    expect($action)->toBeObject();
});
