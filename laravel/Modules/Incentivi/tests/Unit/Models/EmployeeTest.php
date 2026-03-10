<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\Workgroup;
use Illuminate\Database\Eloquent\Collection;

uses(TestCase::class);

test('it can create an employee', function () {
    $employee = Employee::factory()->create([
        'cognome' => 'Rossi',
        'nome' => 'Mario',
    ]);

    expect($employee->cognome)->toBe('Rossi');
    expect($employee->full_name)->toBe('Rossi Mario');
    
    $this->assertDatabaseHas('employees', [
        'id' => $employee->id,
        'cognome' => 'Rossi',
    ], 'incentivi');
});

test('an employee can have many projects', function () {
    $employee = Employee::factory()->create();
    $projects = Project::factory()->count(2)->create();
    
    $employee->projects()->attach($projects);

    expect($employee->projects)->toHaveCount(2);
    expect($employee->projects->first())->toBeInstanceOf(Project::class);
});

test('an employee can have many activities', function () {
    $employee = Employee::factory()->create();
    $activities = Activity::factory()->count(2)->create();
    
    $employee->activities()->attach($activities);

    expect($employee->activities)->toHaveCount(2);
    expect($employee->activities->first())->toBeInstanceOf(Activity::class);
});

test('an employee can have many workgroups', function () {
    $employee = Employee::factory()->create();
    $workgroups = Workgroup::factory()->count(2)->create();
    
    $employee->workgroups()->attach($workgroups);

    expect($employee->workgroups)->toHaveCount(2);
    expect($employee->workgroups->first())->toBeInstanceOf(Workgroup::class);
});
