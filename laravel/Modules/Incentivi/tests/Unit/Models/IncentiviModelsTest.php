<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\ActivityEmployee;
use Modules\Incentivi\Models\CapitalPercentage;
use Modules\Incentivi\Models\DefaultActivity;
use Modules\Incentivi\Models\Employee;
use Modules\Incentivi\Models\EmployeeProject;
use Modules\Incentivi\Models\EmployeeWorkgroup;
use Modules\Incentivi\Models\Phase;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Settlement;
use Modules\Incentivi\Models\StabiDirigente;
use Modules\Incentivi\Models\Workgroup;

it('can instantiate all target incentive models', function (string $class): void {
    $model = new $class();

    expect($model)->toBeInstanceOf($class)
        ->and($model)->toBeInstanceOf(Model::class);
})->with([
    Activity::class,
    ActivityEmployee::class,
    CapitalPercentage::class,
    DefaultActivity::class,
    Employee::class,
    EmployeeProject::class,
    EmployeeWorkgroup::class,
    Phase::class,
    Project::class,
    Settlement::class,
    StabiDirigente::class,
    Workgroup::class,
]);

it('exposes expected core relationships', function (): void {
    $activity = new Activity();
    $project = new Project();
    $employee = new Employee();
    $settlement = new Settlement();

    expect($activity->project())->toBeInstanceOf(BelongsTo::class)
        ->and($activity->employees())->toBeInstanceOf(BelongsToMany::class)
        ->and($project->activities())->toBeInstanceOf(HasMany::class)
        ->and($project->employees())->toBeInstanceOf(BelongsToMany::class)
        ->and($employee->projects())->toBeInstanceOf(BelongsToMany::class)
        ->and($employee->activities())->toBeInstanceOf(BelongsToMany::class)
        ->and($employee->workgroups())->toBeInstanceOf(BelongsToMany::class)
        ->and($settlement->project())->toBeInstanceOf(BelongsTo::class)
        ->and($settlement->linkable())->toBeInstanceOf(MorphTo::class);
});

it('computes full name accessor on employee', function (): void {
    $employee = new Employee();
    $employee->cognome = 'Rossi';
    $employee->nome = 'Mario';

    expect($employee->full_name)->toBe('Rossi Mario');
});

it('resolves workgroup id accessor from related project in activity', function (): void {
    $project = new Project();
    $project->workgroup_id = 42;

    $activity = new Activity();
    $activity->setRelation('project', $project);

    expect($activity->workgroup_id)->toBe(42);
});
