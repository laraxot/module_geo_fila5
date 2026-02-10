<?php

declare(strict_types=1);

use Modules\Incentivi\Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| Il TestCase per il modulo Incentivi usa RefreshDatabase per isolamento
| dei dati tra i test. Viene usato per i test Feature e Unit.
|
*/

uses(TestCase::class)->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| Qui puoi estendere le expectation api di Pest con metodi custom
| specifici per il modulo Incentivi.
|
*/

expect()->extend('toBeProject', function () {
    return $this->toBeInstanceOf(\Modules\Incentivi\Models\Project::class);
});

expect()->extend('toBeActivity', function () {
    return $this->toBeInstanceOf(\Modules\Incentivi\Models\Activity::class);
});

expect()->extend('toBeEmployee', function () {
    return $this->toBeInstanceOf(\Modules\Incentivi\Models\Employee::class);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| Helper functions specifici per i test del modulo Incentivi.
|
*/

function createProject(array $attributes = []): \Modules\Incentivi\Models\Project
{
    $project = \Modules\Incentivi\Models\Project::factory()->create($attributes);
    assert($project instanceof \Modules\Incentivi\Models\Project);
    return $project;
}

function createActivity(array $attributes = []): \Modules\Incentivi\Models\Activity
{
    $activity = \Modules\Incentivi\Models\Activity::factory()->create($attributes);
    assert($activity instanceof \Modules\Incentivi\Models\Activity);
    return $activity;
}

function createEmployee(array $attributes = []): \Modules\Incentivi\Models\Employee
{
    $employee = \Modules\Incentivi\Models\Employee::factory()->create($attributes);
    assert($employee instanceof \Modules\Incentivi\Models\Employee);
    return $employee;
}
