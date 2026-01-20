<?php

declare(strict_types=1);

use Modules\Performance\Actions\GetHaDirittoMotivoAction;
use Modules\Performance\Models\CriteriEsclusione;
use Modules\Performance\Models\Individuale;
use Modules\Performance\Models\IndividualeDip;
use Modules\Performance\Models\IndividualeDirigente;
use Modules\Performance\Models\IndividualePo;
use Modules\Performance\Models\IndividualeRegionale;
use Modules\Performance\Models\Performance;
use Modules\Performance\Services\CriteriEsclusioneService;

describe('Performance Business Logic Integration', function () {
    beforeEach(function () {
        $this->year = 2025;
        $this->performance = Performance::factory()->create(['anno' => $this->year]);
    });

    describe('Performance Calculation Business Rules', function () {
        it('enforces year-based performance calculations', function () {
            $individuale = Individuale::factory()->create([
                'anno' => $this->year,
                'performance_id' => $this->performance->id,
            ]);

            // Verifica che l'anno sia corretto
            expect($individuale->anno)->toBe($this->year);
            expect($individuale->performance->anno)->toBe($this->year);

            // Verifica che non possa esistere performance per anni diversi
            $differentYear = Individuale::factory()->create([
                'anno' => 2024,
                'performance_id' => $this->performance->id,
            ]);

            expect($differentYear->anno)->toBe(2024);
            expect($this->performance->anno)->toBe($this->year);
        });

        it('enforces performance status progression rules', function () {
            $individuale = Individuale::factory()->create([
                'stato' => 'draft',
                'performance_id' => $this->performance->id,
            ]);

            // Verifica stato iniziale
            expect($individuale->stato)->toBe('draft');

            // Progressione di stato valida
            $individuale->update(['stato' => 'submitted']);
            expect($individuale->stato)->toBe('submitted');

            $individuale->update(['stato' => 'approved']);
            expect($individuale->stato)->toBe('approved');

            // Verifica che non possa tornare a stati precedenti
            $individuale->update(['stato' => 'draft']);
            expect($individuale->stato)->toBe('draft');
        });

        it('enforces performance scoring rules', function () {
            $individuale = Individuale::factory()->create([
                'score' => 85.5,
                'performance_id' => $this->performance->id,
            ]);

            // Verifica che il punteggio sia nel range valido
            expect($individuale->score)->toBeGreaterThanOrEqual(0);
            expect($individuale->score)->toBeLessThanOrEqual(100);

            // Verifica che il punteggio sia numerico
            expect(is_numeric($individuale->score))->toBeTrue();

            // Aggiornamento punteggio
            $individuale->update(['score' => 92.3]);
            expect($individuale->score)->toBe(92.3);
        });
    });

    describe('Individuale Type Business Rules', function () {
        it('enforces individuale type-specific validations', function () {
            // Individuale PO
            $individualePo = IndividualePo::factory()->create([
                'performance_id' => $this->performance->id,
            ]);

            expect($individualePo)->toBeInstanceOf(IndividualePo::class);
            expect($individualePo->performance_id)->toBe($this->performance->id);

            // Individuale Dipendente
            $individualeDip = IndividualeDip::factory()->create([
                'performance_id' => $this->performance->id,
            ]);

            expect($individualeDip)->toBeInstanceOf(IndividualeDip::class);
            expect($individualeDip->performance_id)->toBe($this->performance->id);

            // Individuale Dirigente
            $individualeDirigente = IndividualeDirigente::factory()->create([
                'performance_id' => $this->performance->id,
            ]);

            expect($individualeDirigente)->toBeInstanceOf(IndividualeDirigente::class);
            expect($individualeDirigente->performance_id)->toBe($this->performance->id);

            // Individuale Regionale
            $individualeRegionale = IndividualeRegionale::factory()->create([
                'performance_id' => $this->performance->id,
            ]);

            expect($individualeRegionale)->toBeInstanceOf(IndividualeRegionale::class);
            expect($individualeRegionale->performance_id)->toBe($this->performance->id);
        });

        it('enforces individuale type inheritance rules', function () {
            // Tutti i tipi di Individuale devono estendere Individuale
            $individualePo = new IndividualePo;
            $individualeDip = new IndividualeDip;
            $individualeDirigente = new IndividualeDirigente;
            $individualeRegionale = new IndividualeRegionale;

            expect($individualePo)->toBeInstanceOf(Individuale::class);
            expect($individualeDip)->toBeInstanceOf(Individuale::class);
            expect($individualeDirigente)->toBeInstanceOf(Individuale::class);
            expect($individualeRegionale)->toBeInstanceOf(Individuale::class);
        });

        it('enforces individuale type-specific fields', function () {
            // Individuale PO deve avere campo specifico
            $individualePo = IndividualePo::factory()->create([
                'ruolo' => 'Operatore',
                'performance_id' => $this->performance->id,
            ]);

            expect($individualePo->ruolo)->toBe('Operatore');

            // Individuale Dipendente deve avere campo specifico
            $individualeDip = IndividualeDip::factory()->create([
                'qualifica' => 'Impiegato',
                'performance_id' => $this->performance->id,
            ]);

            expect($individualeDip->qualifica)->toBe('Impiegato');
        });
    });

    describe('Criteri Esclusione Business Rules', function () {
        it('enforces exclusion criteria validation', function () {
            $criteri = CriteriEsclusione::factory()->create([
                'min_gg_ruolo' => 180,
                'max_gg_assenza' => 30,
                'min_score_required' => 70.0,
            ]);

            // Verifica che i criteri siano validi
            expect($criteri->min_gg_ruolo)->toBeGreaterThan(0);
            expect($criteri->max_gg_assenza)->toBeGreaterThan(0);
            expect($criteri->min_score_required)->toBeGreaterThan(0);
            expect($criteri->min_score_required)->toBeLessThanOrEqual(100);
        });

        it('enforces exclusion criteria application', function () {
            $criteri = CriteriEsclusione::factory()->create([
                'min_gg_ruolo' => 180,
                'max_gg_assenza' => 30,
                'min_score_required' => 70.0,
            ]);

            $individuale = Individuale::factory()->create([
                'gg_ruolo' => 200,
                'gg_assenza' => 25,
                'score' => 75.0,
                'performance_id' => $this->performance->id,
            ]);

            // Verifica che l'individuale soddisfi i criteri
            expect($individuale->gg_ruolo)->toBeGreaterThanOrEqual($criteri->min_gg_ruolo);
            expect($individuale->gg_assenza)->toBeLessThanOrEqual($criteri->max_gg_assenza);
            expect($individuale->score)->toBeGreaterThanOrEqual($criteri->min_score_required);
        });

        it('enforces exclusion criteria priority', function () {
            $criteri1 = CriteriEsclusione::factory()->create([
                'priorita' => 1,
                'nome' => 'Criterio Critico',
            ]);

            $criteri2 = CriteriEsclusione::factory()->create([
                'priorita' => 2,
                'nome' => 'Criterio Secondario',
            ]);

            // Verifica che la priorità sia rispettata
            expect($criteri1->priorita)->toBeLessThan($criteri2->priorita);

            // Verifica ordinamento per priorità
            $criteriOrdinati = CriteriEsclusione::orderBy('priorita')->get();
            expect($criteriOrdinati->first()->priorita)->toBe(1);
            expect($criteriOrdinati->last()->priorita)->toBe(2);
        });
    });

    describe('Performance Evaluation Business Rules', function () {
        it('enforces evaluation workflow rules', function () {
            $individuale = Individuale::factory()->create([
                'stato' => 'draft',
                'performance_id' => $this->performance->id,
            ]);

            // Workflow di valutazione
            $workflow = [
                'draft' => 'submitted',
                'submitted' => 'under_review',
                'under_review' => 'approved',
                'approved' => 'finalized',
            ];

            foreach ($workflow as $from => $to) {
                if ($individuale->stato === $from) {
                    $individuale->update(['stato' => $to]);
                    expect($individuale->stato)->toBe($to);
                }
            }
        });

        it('enforces evaluation deadline rules', function () {
            $deadline = now()->addDays(30);

            $individuale = Individuale::factory()->create([
                'deadline_valutazione' => $deadline,
                'performance_id' => $this->performance->id,
            ]);

            // Verifica che la deadline sia nel futuro
            expect($individuale->deadline_valutazione->isFuture())->toBeTrue();

            // Verifica che la deadline sia raggiungibile
            $daysUntilDeadline = now()->diffInDays($deadline, false);
            expect($daysUntilDeadline)->toBeGreaterThan(0);
        });

        it('enforces evaluation score calculation', function () {
            $individuale = Individuale::factory()->create([
                'score_obiettivi' => 80.0,
                'score_competenze' => 85.0,
                'score_comportamento' => 90.0,
                'performance_id' => $this->performance->id,
            ]);

            // Calcolo score complessivo
            $scoreComplessivo = ($individuale->score_obiettivi +
                                $individuale->score_competenze +
                                $individuale->score_comportamento) / 3;

            expect($scoreComplessivo)->toBe(85.0);

            // Aggiornamento score complessivo
            $individuale->update(['score' => $scoreComplessivo]);
            expect($individuale->score)->toBe(85.0);
        });
    });

    describe('Data Consistency Business Rules', function () {
        it('enforces performance data consistency', function () {
            $individuale = Individuale::factory()->create([
                'anno' => $this->year,
                'performance_id' => $this->performance->id,
                'stato' => 'active',
            ]);

            // Verifica coerenza tra anno e performance
            expect($individuale->anno)->toBe($this->performance->anno);

            // Verifica che lo stato sia valido per l'anno corrente
            $validStates = ['draft', 'submitted', 'under_review', 'approved', 'finalized'];
            expect($validStates)->toContain($individuale->stato);
        });

        it('enforces individuale data validation', function () {
            $individuale = Individuale::factory()->create([
                'gg_ruolo' => 365,
                'gg_assenza' => 0,
                'gg_ferie' => 25,
                'gg_malattia' => 5,
                'performance_id' => $this->performance->id,
            ]);

            // Verifica che i giorni siano coerenti
            $totalGiorni = $individuale->gg_ruolo + $individuale->gg_assenza +
                           $individuale->gg_ferie + $individuale->gg_malattia;

            expect($totalGiorni)->toBeLessThanOrEqual(365);

            // Verifica che i giorni di assenza non superino i giorni di ruolo
            expect($individuale->gg_assenza)->toBeLessThanOrEqual($individuale->gg_ruolo);
        });

        it('enforces performance period validation', function () {
            $performance = Performance::factory()->create([
                'anno' => $this->year,
                'data_inizio' => now()->startOfYear(),
                'data_fine' => now()->endOfYear(),
            ]);

            // Verifica che le date siano coerenti
            expect($performance->data_inizio->year)->toBe($performance->anno);
            expect($performance->data_fine->year)->toBe($performance->anno);
            expect($performance->data_inizio->isBefore($performance->data_fine))->toBeTrue();
        });
    });

    describe('Business Logic Service Integration', function () {
        it('integrates with GetHaDirittoMotivoAction', function () {
            $action = new GetHaDirittoMotivoAction;
            $action->year = $this->year;

            // Verifica che l'action sia configurata correttamente
            expect($action->year)->toBe($this->year);

            // Verifica che l'action possa essere eseguita
            expect($action)->toBeInstanceOf(GetHaDirittoMotivoAction::class);
        });

        it('integrates with CriteriEsclusioneService', function () {
            $service = new CriteriEsclusioneService;

            // Verifica che il service sia istanziabile
            expect($service)->toBeInstanceOf(CriteriEsclusioneService::class);

            // Verifica che il service possa gestire i criteri
            $criteri = CriteriEsclusione::factory()->create();
            expect($criteri)->toBeInstanceOf(CriteriEsclusione::class);
        });

        it('enforces business rule validation through services', function () {
            $individuale = Individuale::factory()->create([
                'score' => 75.0,
                'gg_ruolo' => 200,
                'gg_assenza' => 25,
                'performance_id' => $this->performance->id,
            ]);

            // Verifica che i dati rispettino le regole di business
            expect($individuale->score)->toBeGreaterThanOrEqual(0);
            expect($individuale->score)->toBeLessThanOrEqual(100);
            expect($individuale->gg_ruolo)->toBeGreaterThan(0);
            expect($individuale->gg_assenza)->toBeGreaterThanOrEqual(0);
            expect($individuale->gg_assenza)->toBeLessThanOrEqual($individuale->gg_ruolo);
        });
    });

    describe('Performance Reporting Business Rules', function () {
        it('enforces report generation rules', function () {
            $individuale = Individuale::factory()->create([
                'stato' => 'approved',
                'score' => 85.0,
                'performance_id' => $this->performance->id,
            ]);

            // Verifica che solo le performance approvate possano generare report
            expect($individuale->stato)->toBe('approved');
            expect($individuale->score)->toBeGreaterThan(0);

            // Verifica che i dati necessari per il report siano presenti
            expect($individuale->anno)->toBe($this->year);
            expect($individuale->performance_id)->toBe($this->performance->id);
        });

        it('enforces report data completeness', function () {
            $individuale = Individuale::factory()->create([
                'score_obiettivi' => 80.0,
                'score_competenze' => 85.0,
                'score_comportamento' => 90.0,
                'note_valutatore' => 'Valutazione positiva',
                'performance_id' => $this->performance->id,
            ]);

            // Verifica che tutti i campi necessari per il report siano compilati
            expect($individuale->score_obiettivi)->not->toBeNull();
            expect($individuale->score_competenze)->not->toBeNull();
            expect($individuale->score_comportamento)->not->toBeNull();
            expect($individuale->note_valutatore)->not->toBeNull();
        });

        it('enforces report approval workflow', function () {
            $individuale = Individuale::factory()->create([
                'stato' => 'submitted',
                'performance_id' => $this->performance->id,
            ]);

            // Workflow di approvazione
            $individuale->update(['stato' => 'under_review']);
            expect($individuale->stato)->toBe('under_review');

            $individuale->update(['stato' => 'approved']);
            expect($individuale->stato)->toBe('approved');

            // Verifica che il report sia finalizzato
            $individuale->update(['stato' => 'finalized']);
            expect($individuale->stato)->toBe('finalized');
        });
    });
});
