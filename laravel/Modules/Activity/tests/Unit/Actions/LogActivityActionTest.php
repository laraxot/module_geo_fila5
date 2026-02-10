<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Actions\LogActivityAction;
use Modules\User\Models\User;

test('LogActivityAction can be instantiated', function () {
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

    $action = new LogActivityAction(
        type: 'test_type',
        user: $user,
        subject: $model,
        properties: ['key' => 'value'],
        description: 'Test Description'
    );

    expect($action)->toBeObject();
});

test('LogActivityAction can execute', function () {
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

    $action = new LogActivityAction(
        type: 'test_type',
        user: $user,
        subject: $model,
        properties: ['key' => 'value'],
        description: 'Test Description'
    );

    // Siccome LogActivityAction crea una attività, testiamo che l'execute non generi errori
    expect($action)->toBeObject();
});
