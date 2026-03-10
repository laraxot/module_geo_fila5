<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Models\CapitalPercentage;

uses(TestCase::class);

test('it can create a capital percentage range', function () {
    $cp = CapitalPercentage::factory()->create([
        'tipologia' => 'Tipo Speciale',
        'valore' => 5.5,
    ]);

    expect($cp->tipologia)->toBe('Tipo Speciale');
    expect((float)$cp->valore)->toBe(5.5);
    
    $this->assertDatabaseHas('capital_percentages', [
        'id' => $cp->id,
        'tipologia' => 'Tipo Speciale',
    ], 'incentivi');
});
