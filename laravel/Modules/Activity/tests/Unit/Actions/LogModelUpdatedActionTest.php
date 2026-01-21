<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Actions\LogModelUpdatedAction;
use Modules\User\Models\User;

function makeLogModelUpdatedActionTestModel(array $attributes = []): Model
{
    return new class ($attributes) extends Model {
        protected $table = 'test_models';

        protected $fillable = ['name'];
    };
}

test('LogModelUpdatedAction can be instantiated', function () {
    $model = makeLogModelUpdatedActionTestModel();
    $user = User::factory()->make();

    $action = new LogModelUpdatedAction($model, $user);

    expect($action)->toBeObject()
        ->and($action->model)->toBe($model)
        ->and($action->user)->toBe($user);
});
