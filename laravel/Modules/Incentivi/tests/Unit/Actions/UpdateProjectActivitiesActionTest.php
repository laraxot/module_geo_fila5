<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Actions;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Actions\UpdateProjectActivitiesAction;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\Employee;

uses(TestCase::class);

test('it cascades updates from project to activities and employees', function () {
    // 1. Setup Project
    $project = Project::factory()->create([
        'componente_incentivante' => 10000.0,
    ]);

    // 2. Setup Activity
    $activity = Activity::factory()->create([
        'project_id' => $project->id,
        'quota_percentuale' => 10, // Should get 10% of 10000 = 1000
    ]);

    // 3. Setup Employee
    $employee = Employee::factory()->create();
    $activity->employees()->attach($employee->id, [
        'percentuale_attivita_dipendente' => 50, // Should get 50% of 1000 = 500
    ]);

    // 4. Execute Action
    app(UpdateProjectActivitiesAction::class)->execute($project);

    // 5. Assertions
    $activity->refresh();
    expect((float)$activity->importo)->toBe(1000.0);

    $pivot = $activity->employees()->where('employee_id', $employee->id)->first()->pivot;
    expect((float)$pivot->importo_attivita_dipendente)->toBe(500.0);
});
