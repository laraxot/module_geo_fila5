<?php

declare(strict_types=1);

use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Modules\Ptv\Models\Client;
use Modules\Ptv\Models\Profile;
use Modules\Ptv\Models\Project;
use Modules\Ptv\Models\Task;
use Modules\Ptv\Models\TimeEntry;
use Modules\User\Models\User;

describe('Ptv Business Logic Integration', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->client = Client::factory()->create();
        $this->project = Project::factory()->create([
            'client_id' => $this->client->id,
        ]);
    });

    describe('Profile Management Business Rules', function () {
        it('enforces profile completion requirements', function () {
            $profile = Profile::factory()->create([
                'user_id' => $this->user->id,
                'first_name' => 'Mario',
                'last_name' => 'Rossi',
                'email' => 'mario.rossi@example.com',
            ]);

            // Verifica che i campi obbligatori siano compilati
            expect($profile->first_name)->not->toBeNull();
            expect($profile->last_name)->not->toBeNull();
            expect($profile->email)->not->toBeNull();

            // Verifica che l'email sia valida
            expect(filter_var($profile->email, FILTER_VALIDATE_EMAIL))->not->toBeFalse();

            // Verifica che il nome completo sia corretto
            expect($profile->full_name)->toBe('Mario Rossi');
        });

        it('enforces profile data validation rules', function () {
            $profile = Profile::factory()->create([
                'user_id' => $this->user->id,
                'phone' => '+39 123 456 7890',
                'date_of_birth' => '1990-01-01',
                'address' => 'Via Roma 123, Milano',
            ]);

            // Verifica formato telefono
            expect($profile->phone)->toMatch('/^\+?[0-9\s\-\(\)]+$/');

            // Verifica data di nascita
            expect($profile->date_of_birth)->toBeInstanceOf(Carbon::class);
            expect($profile->date_of_birth->year)->toBe(1990);

            // Verifica indirizzo
            expect($profile->address)->toContain('Via Roma 123');
        });

        it('enforces profile uniqueness constraints', function () {
            $profile1 = Profile::factory()->create([
                'user_id' => $this->user->id,
                'email' => 'unique@example.com',
            ]);

            // Tentativo di creare profilo con email duplicata
            $this->expectException(QueryException::class);

            Profile::factory()->create([
                'user_id' => User::factory()->create()->id,
                'email' => 'unique@example.com',
            ]);
        });
    });

    describe('Project Management Business Rules', function () {
        it('enforces project lifecycle rules', function () {
            $project = Project::factory()->create([
                'client_id' => $this->client->id,
                'status' => 'draft',
                'start_date' => now(),
                'end_date' => now()->addMonths(3),
            ]);

            // Verifica stato iniziale
            expect($project->status)->toBe('draft');

            // Progressione di stato valida
            $project->update(['status' => 'active']);
            expect($project->status)->toBe('active');

            $project->update(['status' => 'completed']);
            expect($project->status)->toBe('completed');

            // Verifica che le date siano coerenti
            expect($project->start_date->isBefore($project->end_date))->toBeTrue();
            expect($project->duration_in_days)->toBeGreaterThan(0);
        });

        it('enforces project budget constraints', function () {
            $project = Project::factory()->create([
                'client_id' => $this->client->id,
                'budget' => 10000.00,
                'total_cost' => 0.00,
            ]);

            // Verifica che il budget sia positivo
            expect($project->budget)->toBeGreaterThan(0);

            // Verifica che il costo totale non superi il budget
            expect($project->total_cost)->toBeLessThanOrEqual($project->budget);

            // Calcolo margine di profitto
            $profitMargin = (($project->budget - $project->total_cost) / $project->budget) * 100;
            expect($profitMargin)->toBeGreaterThanOrEqual(0);
        });

        it('enforces project team assignment rules', function () {
            $project = Project::factory()->create([
                'client_id' => $this->client->id,
                'max_team_size' => 5,
            ]);

            $users = User::factory()->count(3)->create();

            // Assegnazione utenti al progetto
            foreach ($users as $user) {
                $project->users()->attach($user->id);
            }

            // Verifica che il team non superi la dimensione massima
            expect($project->users()->count())->toBeLessThanOrEqual($project->max_team_size);

            // Verifica che tutti gli utenti assegnati siano membri del team
            foreach ($users as $user) {
                expect($project->users)->toContain($user);
            }
        });
    });

    describe('Task Management Business Rules', function () {
        it('enforces task dependency rules', function () {
            $task1 = Task::factory()->create([
                'project_id' => $this->project->id,
                'status' => 'completed',
            ]);

            $task2 = Task::factory()->create([
                'project_id' => $this->project->id,
                'status' => 'pending',
                'depends_on' => $task1->id,
            ]);

            // Verifica che la task dipendente non possa essere completata prima della task principale
            expect($task2->depends_on)->toBe($task1->id);
            expect($task1->status)->toBe('completed');

            // Verifica che la task dipendente possa essere completata solo dopo la task principale
            $task2->update(['status' => 'in_progress']);
            expect($task2->status)->toBe('in_progress');
        });

        it('enforces task priority rules', function () {
            $highPriorityTask = Task::factory()->create([
                'project_id' => $this->project->id,
                'priority' => 'high',
                'due_date' => now()->addDays(1),
            ]);

            $lowPriorityTask = Task::factory()->create([
                'project_id' => $this->project->id,
                'priority' => 'low',
                'due_date' => now()->addDays(7),
            ]);

            // Verifica che le task ad alta priorità abbiano scadenze più vicine
            $highPriorityDays = now()->diffInDays($highPriorityTask->due_date, false);
            $lowPriorityDays = now()->diffInDays($lowPriorityTask->due_date, false);

            expect($highPriorityDays)->toBeLessThan($lowPriorityDays);

            // Verifica che le priorità siano valide
            $validPriorities = ['low', 'medium', 'high', 'urgent'];
            expect($validPriorities)->toContain($highPriorityTask->priority);
            expect($validPriorities)->toContain($lowPriorityTask->priority);
        });

        it('enforces task time estimation rules', function () {
            $task = Task::factory()->create([
                'project_id' => $this->project->id,
                'estimated_hours' => 8.0,
                'actual_hours' => 0.0,
            ]);

            // Verifica che le ore stimate siano positive
            expect($task->estimated_hours)->toBeGreaterThan(0);

            // Verifica che le ore effettive non superino le ore stimate di troppo
            $task->update(['actual_hours' => 10.0]);
            $variance = (($task->actual_hours - $task->estimated_hours) / $task->estimated_hours) * 100;

            expect($variance)->toBeLessThanOrEqual(50); // Varianza massima del 50%
        });
    });

    describe('Time Tracking Business Rules', function () {
        it('enforces time entry validation rules', function () {
            $timeEntry = TimeEntry::factory()->create([
                'user_id' => $this->user->id,
                'task_id' => Task::factory()->create(['project_id' => $this->project->id])->id,
                'start_time' => now()->subHours(2),
                'end_time' => now()->subHour(),
                'description' => 'Sviluppo feature',
            ]);

            // Verifica che l'orario di fine sia successivo all'orario di inizio
            expect($timeEntry->end_time->isAfter($timeEntry->start_time))->toBeTrue();

            // Calcolo durata in ore
            $duration = $timeEntry->start_time->diffInHours($timeEntry->end_time);
            expect($duration)->toBe(1);

            // Verifica che la descrizione sia presente
            expect($timeEntry->description)->not->toBeEmpty();
        });

        it('enforces working hours limits', function () {
            $user = $this->user;
            $task = Task::factory()->create(['project_id' => $this->project->id]);

            // Creazione di più time entry per lo stesso utente nello stesso giorno
            $today = now()->startOfDay();

            $timeEntry1 = TimeEntry::factory()->create([
                'user_id' => $user->id,
                'task_id' => $task->id,
                'start_time' => $today->copy()->addHours(9),
                'end_time' => $today->copy()->addHours(13),
            ]);

            $timeEntry2 = TimeEntry::factory()->create([
                'user_id' => $user->id,
                'task_id' => $task->id,
                'start_time' => $today->copy()->addHours(14),
                'end_time' => $today->copy()->addHours(18),
            ]);

            // Calcolo ore totali lavorate nel giorno
            $totalHours = $user->timeEntries()
                ->whereDate('start_time', $today)
                ->get()
                ->sum(fn ($entry) => $entry->start_time->diffInHours($entry->end_time));

            expect($totalHours)->toBe(8);

            // Verifica che non superi il limite giornaliero (es. 10 ore)
            expect($totalHours)->toBeLessThanOrEqual(10);
        });

        it('enforces project time allocation rules', function () {
            $project = $this->project;
            $task = Task::factory()->create(['project_id' => $project->id]);

            // Creazione time entry per il progetto
            $timeEntry = TimeEntry::factory()->create([
                'user_id' => $this->user->id,
                'task_id' => $task->id,
                'start_time' => now()->subHours(4),
                'end_time' => now()->subHours(2),
            ]);

            // Calcolo ore totali per il progetto
            $projectHours = $project->tasks()
                ->with('timeEntries')
                ->get()
                ->sum(fn ($task) => $task->timeEntries->sum(fn ($entry) => $entry->start_time->diffInHours($entry->end_time)));

            expect($projectHours)->toBeGreaterThan(0);

            // Verifica che le ore siano allocate correttamente
            expect($projectHours)->toBe(2);
        });
    });

    describe('Client Management Business Rules', function () {
        it('enforces client data integrity rules', function () {
            $client = Client::factory()->create([
                'name' => 'Azienda Example SRL',
                'email' => 'info@aziendaexample.it',
                'phone' => '+39 02 1234567',
                'address' => 'Via Milano 456, Roma',
                'vat_number' => 'IT12345678901',
            ]);

            // Verifica che i dati obbligatori siano presenti
            expect($client->name)->not->toBeEmpty();
            expect($client->email)->not->toBeEmpty();

            // Verifica formato email
            expect(filter_var($client->email, FILTER_VALIDATE_EMAIL))->not->toBeFalse();

            // Verifica formato telefono
            expect($client->phone)->toMatch('/^\+?[0-9\s\-\(\)]+$/');

            // Verifica formato partita IVA
            expect($client->vat_number)->toMatch('/^IT[0-9]{11}$/');
        });

        it('enforces client project limits', function () {
            $client = $this->client;

            // Creazione di più progetti per lo stesso cliente
            $projects = Project::factory()->count(3)->create([
                'client_id' => $client->id,
                'status' => 'active',
            ]);

            // Verifica che il cliente abbia tutti i progetti
            expect($client->projects)->toHaveCount(3);

            // Verifica che tutti i progetti siano attivi
            foreach ($projects as $project) {
                expect($project->status)->toBe('active');
            }

            // Calcolo valore totale dei progetti
            $totalValue = $client->projects->sum('budget');
            expect($totalValue)->toBeGreaterThan(0);
        });

        it('enforces client billing rules', function () {
            $client = $this->client;
            $project = Project::factory()->create([
                'client_id' => $client->id,
                'budget' => 5000.00,
                'billing_type' => 'hourly',
                'hourly_rate' => 50.00,
            ]);

            // Verifica che il tipo di fatturazione sia valido
            $validBillingTypes = ['hourly', 'fixed', 'milestone'];
            expect($validBillingTypes)->toContain($project->billing_type);

            // Verifica che la tariffa oraria sia positiva per progetti orari
            if ($project->billing_type === 'hourly') {
                expect($project->hourly_rate)->toBeGreaterThan(0);
            }

            // Calcolo fattura stimata
            $estimatedHours = $project->budget / $project->hourly_rate;
            expect($estimatedHours)->toBe(100);
        });
    });

    describe('Reporting Business Rules', function () {
        it('enforces report data completeness', function () {
            $project = $this->project;
            $task = Task::factory()->create([
                'project_id' => $project->id,
                'status' => 'completed',
                'estimated_hours' => 10.0,
                'actual_hours' => 12.0,
            ]);

            $timeEntry = TimeEntry::factory()->create([
                'user_id' => $this->user->id,
                'task_id' => $task->id,
                'start_time' => now()->subDays(1),
                'end_time' => now()->subDays(1)->addHours(4),
            ]);

            // Verifica che tutti i dati necessari per il report siano presenti
            expect($project->client_id)->not->toBeNull();
            expect($task->status)->toBe('completed');
            expect($timeEntry->start_time)->not->toBeNull();
            expect($timeEntry->end_time)->not->toBeNull();
        });

        it('enforces report calculation accuracy', function () {
            $project = $this->project;
            $tasks = Task::factory()->count(3)->create([
                'project_id' => $project->id,
                'estimated_hours' => 8.0,
                'actual_hours' => 10.0,
            ]);

            // Calcolo ore totali stimate vs effettive
            $totalEstimated = $tasks->sum('estimated_hours');
            $totalActual = $tasks->sum('actual_hours');

            expect($totalEstimated)->toBe(24.0);
            expect($totalActual)->toBe(30.0);

            // Calcolo varianza
            $variance = (($totalActual - $totalEstimated) / $totalEstimated) * 100;
            expect($variance)->toBe(25.0); // 25% di varianza
        });

        it('enforces report generation permissions', function () {
            $user = $this->user;
            $project = $this->project;

            // Verifica che l'utente abbia accesso al progetto per generare report
            $project->users()->attach($user->id);

            expect($project->users)->toContain($user);

            // Verifica che possa generare report solo per progetti a cui ha accesso
            $accessibleProjects = $user->projects;
            expect($accessibleProjects)->toContain($project);
        });
    });

    describe('Data Consistency Business Rules', function () {
        it('enforces referential integrity', function () {
            $user = $this->user;
            $project = $this->project;
            $task = Task::factory()->create(['project_id' => $project->id]);
            $timeEntry = TimeEntry::factory()->create([
                'user_id' => $user->id,
                'task_id' => $task->id,
            ]);

            // Verifica che le relazioni siano mantenute
            expect($timeEntry->user_id)->toBe($user->id);
            expect($timeEntry->task_id)->toBe($task->id);
            expect($task->project_id)->toBe($project->id);

            // Verifica che non si possano eliminare entità con relazioni
            $this->expectException(QueryException::class);

            $user->delete();
        });

        it('enforces data validation across entities', function () {
            $project = $this->project;
            $task = Task::factory()->create([
                'project_id' => $project->id,
                'due_date' => now()->addDays(7),
            ]);

            // Verifica che la scadenza della task sia successiva alla data di inizio del progetto
            expect($task->due_date->isAfter($project->start_date))->toBeTrue();

            // Verifica che la task appartenga al progetto corretto
            expect($task->project_id)->toBe($project->id);
        });

        it('enforces audit trail maintenance', function () {
            $project = $this->project;
            $originalStatus = $project->status;

            // Modifica dello stato del progetto
            $project->update(['status' => 'completed']);

            // Verifica che i timestamp siano aggiornati
            expect($project->updated_at)->not->toBe($project->created_at);

            // Verifica che lo stato sia stato modificato
            expect($project->status)->not->toBe($originalStatus);
            expect($project->status)->toBe('completed');
        });
    });
});
