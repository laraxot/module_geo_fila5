<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Actions;

use Illuminate\Database\Eloquent\Model;
use Modules\Incentivi\Actions\UpdateActivitiesEmployeesAction;

function makeUpdateActivitiesPivotStub(): Model
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

function makeUpdateActivitiesEmployeeStub(mixed $pivot = null): Model
{
    $employee = new class extends Model {
        public mixed $pivot = null;
    };
    $employee->pivot = $pivot;

    return $employee;
}

function makeUpdateActivitiesRecordStub(): Model
{
    return new class extends Model {
    };
}

it('returns early when record is null', function (): void {
    $action = app(UpdateActivitiesEmployeesAction::class);

    $action->execute(null);

    expect(true)->toBeTrue();
});

it('updates employee pivot amount using importo_totale', function (): void {
    $pivot = makeUpdateActivitiesPivotStub();
    $employee = makeUpdateActivitiesEmployeeStub($pivot);
    $employee->pivot->percentuale_attivita_dipendente = 25;

    $record = makeUpdateActivitiesRecordStub();
    $record->importo_totale = 1000;
    $record->setRelation('employees', collect([$employee]));

    app(UpdateActivitiesEmployeesAction::class)->execute($record);

    expect($pivot->lastUpdated['importo_attivita_dipendente'])->toBe(250.0);
});

it('falls back to importo field and skips invalid pivots', function (): void {
    $validPivot = makeUpdateActivitiesPivotStub();
    $validEmployee = makeUpdateActivitiesEmployeeStub($validPivot);
    $validEmployee->pivot->percentuale_attivita_dipendente = 50;

    $invalidEmployee = makeUpdateActivitiesEmployeeStub(null);

    $record = makeUpdateActivitiesRecordStub();
    $record->importo = 300;
    $record->setRelation('employees', collect([$validEmployee, $invalidEmployee]));

    app(UpdateActivitiesEmployeesAction::class)->execute($record);

    expect($validPivot->lastUpdated['importo_attivita_dipendente'])->toBe(150.0);
});
