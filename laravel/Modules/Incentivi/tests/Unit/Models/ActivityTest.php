<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

uses(TestCase::class);

test('it can create an activity', function () {
    $activity = Activity::factory()->create([
        'nome' => 'Test Activity',
    ]);

    expect($activity->nome)->toBe('Test Activity');
    $this->assertDatabaseHas('activities', [
        'id' => $activity->id,
        'nome' => 'Test Activity',
    ], 'incentivi');
});

test('an activity belongs to a project', function () {
    $project = Project::factory()->create();
    $activity = Activity::factory()->create([
        'project_id' => $project->id,
    ]);

    expect($activity->project)->toBeInstanceOf(Project::class);
    expect($activity->project->id)->toBe($project->id);
});

test('an activity can have many employees', function () {
    $activity = Activity::factory()->create();
    $employees = Employee::factory()->count(3)->create();
    
    $activity->employees()->attach($employees);

    expect($activity->employees)->toHaveCount(3);
    expect($activity->employees)->toBeInstanceOf(Collection::class);
    expect($activity->employees->first())->toBeInstanceOf(Employee::class);
});
