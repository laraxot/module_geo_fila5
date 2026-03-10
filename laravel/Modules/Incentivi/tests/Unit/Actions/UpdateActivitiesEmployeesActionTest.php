<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Actions;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Actions\UpdateActivitiesEmployeesAction;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\Employee;

uses(TestCase::class);

test('it updates employee pivot shares based on activity amount', function () {
    // 1. Setup Data
    $activity = Activity::factory()->create([
        'importo' => 1000.0,
    ]);

    $employee1 = Employee::factory()->create();
    $employee2 = Employee::factory()->create();

    // Attach employees with specific percentages in pivot
    $activity->employees()->attach($employee1->id, [
        'percentuale_attivita_dipendente' => 50, // Should get 500
    ]);
    $activity->employees()->attach($employee2->id, [
        'percentuale_attivita_dipendente' => 25, // Should get 250
    ]);

    // 2. Execute Action
    app(UpdateActivitiesEmployeesAction::class)->execute($activity);

    // 3. Assertions
    $pivot1 = $activity->employees()->where('employee_id', $employee1->id)->first()->pivot;
    $pivot2 = $activity->employees()->where('employee_id', $employee2->id)->first()->pivot;

    expect((float)$pivot1->importo_attivita_dipendente)->toBe(500.0);
    expect((float)$pivot2->importo_attivita_dipendente)->toBe(250.0);
});
