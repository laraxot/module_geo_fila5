<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Models\Phase;
use Modules\Incentivi\Models\Project;

uses(TestCase::class);

test('it can create a phase', function () {
    $project = Project::factory()->create();
    $phase = Phase::factory()->create([
        'name' => 'Fase 1',
        'project_id' => $project->id,
    ]);

    expect($phase->name)->toBe('Fase 1');
    expect($phase->project->id)->toBe($project->id);
    
    $this->assertDatabaseHas('phases', [
        'id' => $phase->id,
        'name' => 'Fase 1',
    ], 'incentivi');
});
