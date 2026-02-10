<?php

declare(strict_types=1);

namespace Modules\Incentivi\Tests\Unit;

use Modules\Incentivi\Enums\ProjectStatus;
use Modules\Incentivi\Models\Project;
use Modules\Incentivi\Models\Activity;
use Modules\Incentivi\Models\CapitalPercentage;


test('il model Project esiste ed è istanziabile', function () {
    $project = new Project();
    expect($project)->toBeInstanceOf(Project::class);
});

test('il model Activity esiste ed è istanziabile', function () {
    $activity = new Activity();
    expect($activity)->toBeInstanceOf(Activity::class);
});

test('il model CapitalPercentage esiste ed è istanziabile', function () {
    $capitalPercentage = new CapitalPercentage();
    expect($capitalPercentage)->toBeInstanceOf(CapitalPercentage::class);
});

// beforeEach(function () {
//     $this->project = Project::factory()->create([
//         'nome' => 'Progetto di Test',
        // 'tipo' => 'Servizi',
        // 'stato' => ProjectStatus::Compilazione->value,
        // 'data_aggiudicazione' => now()->subYear(),
        // 'data_inizio_esecuzione' => now()->subYear(),
        // 'data_fine_esecuzione' => now()->addYear(),
        // 'ente_finanziatore' => 'Comune di Test',
        // 'oggetto' => 'Realizzazione di un sistema di test',
        // 'determina' => 'DET12345',
        // 'percentuale_fondo' => 2.0,
        // 'importo_totale' => 100000.00,
        // 'importo_effettivo_fondo' => 2000.00,
        // 'componente_incentivante' => 1000.00,
        // 'componente_innovazione' => 1000.00,
        // 'rup' => 'RUP Test',
        // 'dec' => 'DEC Test',
        // 'ditta_nome' => 'test',
        // 'ditta_sede' => 'test',
        // 'ditta_partitaiva' => '12345678901',
        // 'ditta_oneri_sicurezza' => 'test',
        // 'ditta_trattativa' => 'test',    
//         ]);
// });



// test('un progetto può essere creato', function () {
//     expect($this->project)->toBeProject();
//     expect($this->project->id)->toBeInt();
//     expect($this->project->nome)->toBeString();
// });


// test('un progetto può avere attività', function () {
//     $project = Project::factory()->create();
//     $activity = Activity::factory()->create(['project_id' => $project->id]);

//     expect($project->activities)->toHaveCount(1);
//     expect($project->activities->first()->id)->toBe($activity->id);
// });

// test('un progetto ha lo stato corretto', function () {
//     $project = Project::factory()->create([
//         'stato' => ProjectStatus::Compilazione,
//     ]);

//     expect($project->stato)->toBe(ProjectStatus::Compilazione);
// });

// test('un progetto può essere aggiornato', function () {
//     $project = Project::factory()->create(['nome' => 'Progetto Originale']);

//     $project->update(['nome' => 'Progetto Aggiornato']);

//     expect($project->nome)->toBe('Progetto Aggiornato');
// });

// test('un progetto può essere eliminato', function () {
//     $project = Project::factory()->create();
//     $id = $project->id;

//     $project->delete();

//     expect(Project::find($id))->toBeNull();
// });

// test('un progetto ha i campi data corretti', function () {
//     $project = createProject();

//     expect($project->created_at)->toBeInstanceOf(\Carbon\Carbon::class);
//     expect($project->updated_at)->toBeInstanceOf(\Carbon\Carbon::class);
// });
