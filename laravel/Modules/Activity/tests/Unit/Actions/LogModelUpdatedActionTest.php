<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Actions\LogModelUpdatedAction;
use Modules\Activity\Tests\Fixtures\LogModelUpdatedActionTestModel;
use Modules\User\Models\User;

test('LogModelUpdatedAction can be instantiated', function () {
    $model = new LogModelUpdatedActionTestModel();
    $user = User::factory()->make();

    $action = new LogModelUpdatedAction($model, $user);

    expect($action)->toBeObject()
        ->and($action->model)->toBe($model)
        ->and($action->user)->toBe($user);
});
