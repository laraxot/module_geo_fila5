<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\Employee;
use Illuminate\Database\Eloquent\Collection;

uses(TestCase::class);

test('it can create a project', function () {
    $project = Project::factory()->create([
        'nome' => 'Test Project',
    ]);

    expect($project->nome)->toBe('Test Project');
    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'nome' => 'Test Project',
    ], 'incentivi');
});

test('a project has many activities', function () {
    $project = Project::factory()->create();
    $activities = Activity::factory()->count(3)->create([
        'project_id' => $project->id,
    ]);

    expect($project->activities)->toHaveCount(3);
    expect($project->activities)->toBeInstanceOf(Collection::class);
    expect($project->activities->first())->toBeInstanceOf(Activity::class);
});

test('a project can have many employees', function () {
    $project = Project::factory()->create();
    $employees = Employee::factory()->count(2)->create();
    
    $project->employees()->attach($employees);

    expect($project->employees)->toHaveCount(2);
    expect($project->employees)->toBeInstanceOf(Collection::class);
    expect($project->employees->first())->toBeInstanceOf(Employee::class);
});
