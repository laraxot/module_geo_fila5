<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit\Models;

use Modules\Incentivi\Tests\TestCase;
use Modules\Incentivi\Models\Settlement;
use Modules\Incentivi\Models\Project;

uses(TestCase::class);

test('it can create a settlement', function () {
    $project = Project::factory()->create();
    $settlement = Settlement::factory()->create([
        'denominazione' => 'Liquidazione Marzo',
        'project_id' => $project->id,
    ]);

    expect($settlement->denominazione)->toBe('Liquidazione Marzo');
    expect($settlement->project->id)->toBe($project->id);
    
    $this->assertDatabaseHas('settlements', [
        'id' => $settlement->id,
        'denominazione' => 'Liquidazione Marzo',
    ], 'incentivi');
});

test('a settlement has a linkable morph relation', function () {
    $project = Project::factory()->create();
    $settlement = Settlement::factory()->create([
        'model_type' => Project::class,
        'model_id' => $project->id,
    ]);

    expect($settlement->linkable)->toBeInstanceOf(Project::class);
    expect($settlement->linkable->id)->toBe($project->id);
});
