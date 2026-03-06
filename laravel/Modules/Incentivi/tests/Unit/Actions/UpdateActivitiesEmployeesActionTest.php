<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Actions\UpdateActivitiesEmployeesAction;

class UpdateActivitiesEmployeesPivotStub extends Model
{
    public array $lastUpdated = [];

    public function update(array $attributes = [], array $options = []): bool
    {
        $this->lastUpdated = $attributes;

        return true;
    }
}

class UpdateActivitiesEmployeesEmployeeStub extends Model
{
    public mixed $pivot = null;
}

class UpdateActivitiesEmployeesRecordStub extends Model
{
}

it('returns early when record is null', function (): void {
    $action = app(UpdateActivitiesEmployeesAction::class);

    $action->execute(null);

    expect(true)->toBeTrue();
});

it('updates employee pivot amount using importo_totale', function (): void {
    $pivot = new UpdateActivitiesEmployeesPivotStub();
    $employee = new UpdateActivitiesEmployeesEmployeeStub();
    $employee->pivot = $pivot;
    $employee->pivot->percentuale_attivita_dipendente = 25;

    $record = new UpdateActivitiesEmployeesRecordStub();
    $record->importo_totale = 1000;
    $record->setRelation('employees', collect([$employee]));

    app(UpdateActivitiesEmployeesAction::class)->execute($record);

    expect($pivot->lastUpdated['importo_attivita_dipendente'])->toBe(250.0);
});

it('falls back to importo field and skips invalid pivots', function (): void {
    $validPivot = new UpdateActivitiesEmployeesPivotStub();
    $validEmployee = new UpdateActivitiesEmployeesEmployeeStub();
    $validEmployee->pivot = $validPivot;
    $validEmployee->pivot->percentuale_attivita_dipendente = 50;

    $invalidEmployee = new UpdateActivitiesEmployeesEmployeeStub();
    $invalidEmployee->pivot = null;

    $record = new UpdateActivitiesEmployeesRecordStub();
    $record->importo = 300;
    $record->setRelation('employees', collect([$validEmployee, $invalidEmployee]));

    app(UpdateActivitiesEmployeesAction::class)->execute($record);

    expect($validPivot->lastUpdated['importo_attivita_dipendente'])->toBe(150.0);
});
