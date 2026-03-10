<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Actions;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Actions\SpareImportoTotaleAction;
use Modules\Incentivi\Models\CapitalPercentage;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Mockery;

uses(TestCase::class);

test('it calculates fund components correctly based on amount', function () {
    // 1. Setup Data
    CapitalPercentage::create([
        'tipologia' => 'TestIncentivo',
        'da' => 0,
        'a' => 100000,
        'valore' => 2.0, // 2%
        'nome' => 'Test Range',
    ]);

    // 2. Mock Filament Get/Set
    $get = Mockery::mock(Get::class);
    $set = Mockery::mock(Set::class);

    // Mock get('tipo') - returns an object with value property as per action logic
    $get->shouldReceive('__invoke')
        ->with('tipo')
        ->andReturn((object)['value' => 'TestIncentivo']);

    // Mock get('importo_effettivo_fondo')
    $get->shouldReceive('__invoke')
        ->with('importo_effettivo_fondo')
        ->andReturn(2000.0);

    // Assertions for set() calls
    // Percentage should be 2.0
    $set->shouldReceive('__invoke')
        ->once()
        ->with('percentuale_fondo', 2.0);

    // Effective fund should be 2% of 100,000 = 2000.0
    $set->shouldReceive('__invoke')
        ->once()
        ->with('importo_effettivo_fondo', 2000.0);

    // Incentive component should be 80% of 2000 = 1600.0
    $set->shouldReceive('__invoke')
        ->once()
        ->with('componente_incentivante', 1600.0);

    // Innovation component should be 20% of 2000 = 400.0
    $set->shouldReceive('__invoke')
        ->once()
        ->with('componente_innovazione', 400.0);

    // 3. Execute
    $action = app(SpareImportoTotaleAction::class);
    $action->execute(100000.0, $get, $set);
});

test('it sets values to zero if no range is found', function () {
    $get = Mockery::mock(Get::class);
    $set = Mockery::mock(Set::class);

    $get->shouldReceive('__invoke')
        ->with('tipo')
        ->andReturn((object)['value' => 'NonExistent']);

    $set->shouldReceive('__invoke')->with('percentuale_fondo', 0)->once();
    $set->shouldReceive('__invoke')->with('importo_effettivo_fondo', 0)->once();
    $set->shouldReceive('__invoke')->with('componente_incentivante', 0)->once();
    $set->shouldReceive('__invoke')->with('componente_innovazione', 0)->once();

    $action = app(SpareImportoTotaleAction::class);
    $action->execute(100000.0, $get, $set);
});
