<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Actions\LogModelCreatedAction;
use Modules\User\Models\User;

test('LogModelCreatedAction can be instantiated', function () {
<<<<<<< HEAD
    $model = new class extends Model {
=======
    $model = new class() extends Model
    {
>>>>>>> ac0ea089 (.)
        protected $table = 'test_models';

        protected $fillable = ['name'];
    };
    $user = User::factory()->make();

    $action = new LogModelCreatedAction($model, $user);

    expect($action)->toBeObject()
        ->and($action->model)->toBe($model)
        ->and($action->user)->toBe($user);
});

test('LogModelCreatedAction can execute', function () {
<<<<<<< HEAD
    $modelClass = get_class(new class extends Model {
=======
    $modelClass = get_class(new class() extends Model
    {
>>>>>>> ac0ea089 (.)
        protected $table = 'test_models';

        protected $fillable = ['name'];
    });
    $model = new $modelClass(['name' => 'Test']);
    $user = User::factory()->create();

    $action = new LogModelCreatedAction($model, $user);

    // Siccome LogModelCreatedAction chiama LogActivityAction,
    // testiamo che l'execute non generi errori
    expect($action)->toBeObject();
});
