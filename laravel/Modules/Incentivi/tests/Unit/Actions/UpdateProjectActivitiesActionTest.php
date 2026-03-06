<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Actions\UpdateProjectActivitiesAction;
use Modules\Incentivi\Models\Project;

function makeUpdateProjectPivotStub(): Model
{
    return new class extends Model {
        public array $lastUpdated = [];

        public function update(array $attributes = [], array $options = []): bool
        {
            $this->lastUpdated = $attributes;

            return true;
        }
    };
}

function makeUpdateProjectEmployeeStub(mixed $pivot = null): Model
{
    $employee = new class extends Model {
        public mixed $pivot = null;
    };
    $employee->pivot = $pivot;

    return $employee;
}

function makeUpdateProjectActivityStub(): Model
{
    return new class extends Model {
        public array $lastUpdated = [];

        public function update(array $attributes = [], array $options = []): bool
        {
            $this->lastUpdated = $attributes;

            return true;
        }
    };
}

it('returns early for null and non-project records', function (): void {
    $action = app(UpdateProjectActivitiesAction::class);

    $action->execute(null);
    $action->execute(new class extends Model {
    });

    expect(true)->toBeTrue();
});

it('updates activities and employee pivots from project incentive component', function (): void {
    $pivot = makeUpdateProjectPivotStub();
    $employee = makeUpdateProjectEmployeeStub($pivot);
    $employee->pivot->percentuale_attivita_dipendente = 40;

    $activity = makeUpdateProjectActivityStub();
    $activity->quota_percentuale = 50;
    $activity->setRelation('employees', collect([$employee]));

    $project = new Project();
    $project->componente_incentivante = 1000;
    $project->setRelation('activities', collect([$activity]));

    app(UpdateProjectActivitiesAction::class)->execute($project);

    expect($activity->lastUpdated['importo'])->toBe(500.0)
        ->and($pivot->lastUpdated['importo_attivita_dipendente'])->toBe(200.0);
});
