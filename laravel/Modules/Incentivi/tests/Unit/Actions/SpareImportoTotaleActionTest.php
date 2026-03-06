<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Actions;

use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Mockery;
use Modules\Incentivi\Actions\SpareImportoTotaleAction;

afterEach(function (): void {
    Mockery::close();
});

it('sets all computed fields to zero when no percentage range is found', function (): void {
    /** @var \Mockery\MockInterface $capitalPercentage */
    $capitalPercentage = Mockery::mock('alias:Modules\\Incentivi\\Models\\CapitalPercentage');
    $capitalPercentage->shouldReceive('where')->times(3)->andReturnSelf();
    $capitalPercentage->shouldReceive('first')->once()->andReturn(null);

    $state = [];

    /** @var Get&\Mockery\MockInterface $get */
    $get = Mockery::mock(Get::class);
    $get->shouldReceive('__invoke')->andReturnUsing(function (string $path = '') use (&$state): mixed {
        if ($path === 'tipo') {
            return (object) ['value' => 'SERVIZI'];
        }

        return $state[$path] ?? null;
    });

    /** @var Set&\Mockery\MockInterface $set */
    $set = Mockery::mock(Set::class);
    $set->shouldReceive('__invoke')->andReturnUsing(function (string $path, mixed $value) use (&$state): mixed {
        $state[$path] = $value;

        return $value;
    });

    app(SpareImportoTotaleAction::class)->execute(1000.0, $get, $set);

    expect($state)->toMatchArray([
        'percentuale_fondo' => 0,
        'importo_effettivo_fondo' => 0,
        'componente_incentivante' => 0,
        'componente_innovazione' => 0,
    ]);
});

it('computes incentive and innovation components when a percentage exists', function (): void {
    /** @var \Mockery\MockInterface $capitalPercentage */
    $capitalPercentage = Mockery::mock('alias:Modules\\Incentivi\\Models\\CapitalPercentage');
    $capitalPercentage->shouldReceive('where')->times(3)->andReturnSelf();
    $capitalPercentage->shouldReceive('first')->once()->andReturn((object) ['valore' => 10]);

    $state = [];

    /** @var Get&\Mockery\MockInterface $get */
    $get = Mockery::mock(Get::class);
    $get->shouldReceive('__invoke')->andReturnUsing(function (string $path = '') use (&$state): mixed {
        if ($path === 'tipo') {
            return (object) ['value' => 'SERVIZI'];
        }

        return $state[$path] ?? null;
    });

    /** @var Set&\Mockery\MockInterface $set */
    $set = Mockery::mock(Set::class);
    $set->shouldReceive('__invoke')->andReturnUsing(function (string $path, mixed $value) use (&$state): mixed {
        $state[$path] = $value;

        return $value;
    });

    app(SpareImportoTotaleAction::class)->execute(2000.0, $get, $set);

    expect($state['percentuale_fondo'])->toBe(10.0)
        ->and($state['importo_effettivo_fondo'])->toBe(200.0)
        ->and($state['componente_incentivante'])->toBe(160.0)
        ->and($state['componente_innovazione'])->toBe(40.0);
});
