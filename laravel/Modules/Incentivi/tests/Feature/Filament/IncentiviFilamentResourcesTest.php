<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Feature\Filament;

use Modules\Incentivi\Filament\Resources\ActivityResource;
use Modules\Incentivi\Filament\Resources\CapitalPercentageResource;
use Modules\Incentivi\Filament\Resources\DefaultActivityResource;
use Modules\Incentivi\Filament\Resources\EmployeeResource;
use Modules\Incentivi\Filament\Resources\PhaseResource;
use Modules\Incentivi\Filament\Resources\ProjectResource;
use Modules\Incentivi\Filament\Resources\SettlementResource;
use Modules\Incentivi\Filament\Resources\StabiDirigenteResource;
use Modules\Incentivi\Filament\Resources\WorkgroupResource;
use Modules\Xot\Filament\Resources\XotBaseResource;

it('all key incentive resources extend xot base resource', function (string $resourceClass): void {
    expect(is_subclass_of($resourceClass, XotBaseResource::class))->toBeTrue();
})->with([
    ActivityResource::class,
    CapitalPercentageResource::class,
    DefaultActivityResource::class,
    EmployeeResource::class,
    PhaseResource::class,
    ProjectResource::class,
    SettlementResource::class,
    StabiDirigenteResource::class,
    WorkgroupResource::class,
]);

it('core incentive resources expose expected page map keys', function (): void {
    expect(ActivityResource::getPages())->toHaveKeys(['index', 'create', 'edit'])
        ->and(ProjectResource::getPages())->toHaveKeys(['index', 'create', 'edit'])
        ->and(SettlementResource::getPages())->toHaveKeys(['index', 'create', 'edit']);
});
