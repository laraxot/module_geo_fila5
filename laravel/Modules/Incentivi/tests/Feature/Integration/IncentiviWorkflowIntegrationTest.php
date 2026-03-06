<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Feature\Integration;

use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Actions\UpdateActivitiesEmployeesAction;
use Modules\Incentivi\Actions\UpdateProjectActivitiesAction;
use Modules\Incentivi\Models\Project;

class IncentiviIntegrationPivotStub extends Model
{
    public array $lastUpdated = [];

    public function update(array $attributes = [], array $options = []): bool
    {
        $this->lastUpdated = $attributes;

        return true;
    }
}

class IncentiviIntegrationEmployeeStub extends Model
{
    public mixed $pivot = null;
}

class IncentiviIntegrationActivityStub extends Model
{
    public array $lastUpdated = [];

    public function update(array $attributes = [], array $options = []): bool
    {
        $this->lastUpdated = $attributes;

        return true;
    }
}

it('runs project to activity to employee amount propagation workflow', function (): void {
    $pivot = new IncentiviIntegrationPivotStub();
    $employee = new IncentiviIntegrationEmployeeStub();
    $employee->pivot = $pivot;
    $employee->pivot->percentuale_attivita_dipendente = 50;

    $activity = new IncentiviIntegrationActivityStub();
    $activity->quota_percentuale = 20;
    $activity->setRelation('employees', collect([$employee]));

    $project = new Project();
    $project->componente_incentivante = 1000;
    $project->setRelation('activities', collect([$activity]));

    app(UpdateProjectActivitiesAction::class)->execute($project);

    expect($activity->lastUpdated['importo'])->toBe(200.0)
        ->and($pivot->lastUpdated['importo_attivita_dipendente'])->toBe(100.0);

    $record = new class extends Model {};
    $record->importo_totale = 500;
    $record->setRelation('employees', collect([$employee]));

    app(UpdateActivitiesEmployeesAction::class)->execute($record);

    expect($pivot->lastUpdated['importo_attivita_dipendente'])->toBe(250.0);
});
