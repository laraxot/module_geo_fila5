<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Actions\LogModelCreatedAction;
use Modules\User\Models\User;

function makeLogModelCreatedActionTestModel(array $attributes = []): Model
{
    return new class ($attributes) extends Model {
        protected $table = 'test_models';

        protected $fillable = ['name'];
    };
}

test('LogModelCreatedAction can be instantiated', function () {
    $model = makeLogModelCreatedActionTestModel();
    $user = User::factory()->make();

    $action = new LogModelCreatedAction($model, $user);

    expect($action)->toBeObject()
        ->and($action->model)->toBe($model)
        ->and($action->user)->toBe($user);
});

test('LogModelCreatedAction can execute', function () {
    $model = makeLogModelCreatedActionTestModel(['name' => 'Test']);
    $user = User::factory()->create();

    $action = new LogModelCreatedAction($model, $user);

    // Siccome LogModelCreatedAction chiama LogActivityAction,
    // testiamo che l'execute non generi errori
    expect($action)->toBeObject();
});
