<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Actions\LogModelDeletedAction;
use Modules\Activity\Tests\Fixtures\LogModelDeletedActionTestModel;
use Modules\User\Models\User;

test('LogModelDeletedAction can be instantiated', function () {
    $model = new LogModelDeletedActionTestModel();
    $user = User::factory()->make();

    $action = new LogModelDeletedAction($model, $user);

    expect($action)->toBeObject()
        ->and($action->model)->toBe($model)
        ->and($action->user)->toBe($user);
});
