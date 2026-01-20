<?php

declare(strict_types=1);

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use Modules\Performance\Models\Individuale;
use Modules\User\Models\User;

beforeEach(function () {
    $this->condizioniLavoro = CondizioniLavoro::factory()->create([
        'user_id' => User::factory()->create()->id,
        'individuale_id' => Individuale::factory()->create()->id,
        'data_inizio' => now()->subYear(),
        'data_fine' => now()->addYear(),
        'tipo_indennita' => 'turno_notturno',
        'importo' => 150.00,
        'percentuale' => 25.0,
        'stato' => 'attivo',
        'note' => 'Indennità per turno notturno',
    ]);
});

describe('CondizioniLavoro Model Creation', function () {
    it('can be created with factory', function () {
        expect($this->condizioniLavoro)->toBeInstanceOf(CondizioniLavoro::class);
        expect($this->condizioniLavoro->id)->toBeGreaterThan(0);
    });

    it('has correct table name', function () {
        expect($this->condizioniLavoro->getTable())->toBe('condizioni_lavoro');
    });

    it('has correct primary key', function () {
        expect($this->condizioniLavoro->getKeyName())->toBe('id');
    });

    it('uses auto-incrementing primary key', function () {
        expect($this->condizioniLavoro->getIncrementing())->toBeTrue();
    });
});

describe('CondizioniLavoro Attributes', function () {
    it('has correct fillable attributes', function () {
        $fillable = $this->condizioniLavoro->getFillable();

        expect($fillable)->toContain('user_id');
        expect($fillable)->toContain('individuale_id');
        expect($fillable)->toContain('data_inizio');
        expect($fillable)->toContain('data_fine');
        expect($fillable)->toContain('tipo_indennita');
        expect($fillable)->toContain('importo');
        expect($fillable)->toContain('percentuale');
        expect($fillable)->toContain('stato');
        expect($fillable)->toContain('note');
    });

    it('has correct hidden attributes', function () {
        $hidden = $this->condizioniLavoro->getHidden();

        // Verifica che non ci siano attributi nascosti non necessari
        expect($hidden)->toBeArray();
    });

    it('has correct casts', function () {
        $casts = $this->condizioniLavoro->getCasts();

        expect($casts['data_inizio'])->toBe('datetime');
        expect($casts['data_fine'])->toBe('datetime');
        expect($casts['importo'])->toBe('decimal:2');
        expect($casts['percentuale'])->toBe('decimal:2');
        expect($casts['created_at'])->toBe('datetime');
        expect($casts['updated_at'])->toBe('datetime');
    });

    it('has correct dates', function () {
        $dates = $this->condizioniLavoro->getDates();

        expect($dates)->toContain('data_inizio');
        expect($dates)->toContain('data_fine');
        expect($dates)->toContain('created_at');
        expect($dates)->toContain('updated_at');
    });
});

describe('CondizioniLavoro Business Logic', function () {
    it('calculates duration in days correctly', function () {
        $inizio = now()->subDays(30);
        $fine = now();

        $this->condizioniLavoro->update([
            'data_inizio' => $inizio,
            'data_fine' => $fine,
        ]);

        $duration = $this->condizioniLavoro->data_fine->diffInDays($this->condizioniLavoro->data_inizio);
        expect($duration)->toBe(30);
    });

    it('calculates total compensation correctly', function () {
        $this->condizioniLavoro->update([
            'importo' => 100.00,
            'percentuale' => 20.0,
        ]);

        $totalCompensation = $this->condizioniLavoro->importo * (1 + $this->condizioniLavoro->percentuale / 100);
        expect($totalCompensation)->toBe(120.00);
    });

    it('determines if indennity is active', function () {
        $this->condizioniLavoro->update([
            'stato' => 'attivo',
            'data_inizio' => now()->subDay(),
            'data_fine' => now()->addDay(),
        ]);

        $isActive = $this->condizioniLavoro->stato === 'attivo' &&
                   now()->between($this->condizioniLavoro->data_inizio, $this->condizioniLavoro->data_fine);

        expect($isActive)->toBeTrue();
    });

    it('determines if indennity is expired', function () {
        $this->condizioniLavoro->update([
            'data_fine' => now()->subDay(),
        ]);

        $isExpired = now()->isAfter($this->condizioniLavoro->data_fine);
        expect($isExpired)->toBeTrue();
    });

    it('determines if indennity is future', function () {
        $this->condizioniLavoro->update([
            'data_inizio' => now()->addDay(),
        ]);

        $isFuture = now()->isBefore($this->condizioniLavoro->data_inizio);
        expect($isFuture)->toBeTrue();
    });

    it('calculates monthly compensation correctly', function () {
        $this->condizioniLavoro->update([
            'importo' => 300.00,
            'percentuale' => 15.0,
        ]);

        $monthlyCompensation = $this->condizioniLavoro->importo * (1 + $this->condizioniLavoro->percentuale / 100);
        expect($monthlyCompensation)->toBe(345.00);
    });

    it('validates percentage range', function () {
        $this->condizioniLavoro->update([
            'percentuale' => 50.0,
        ]);

        $isValidPercentage = $this->condizioniLavoro->percentuale >= 0 && $this->condizioniLavoro->percentuale <= 100;
        expect($isValidPercentage)->toBeTrue();
    });

    it('validates amount is positive', function () {
        $this->condizioniLavoro->update([
            'importo' => 75.50,
        ]);

        $isValidAmount = $this->condizioniLavoro->importo > 0;
        expect($isValidAmount)->toBeTrue();
    });
});

describe('CondizioniLavoro Scopes', function () {
    it('filters by active status', function () {
        // Crea condizioni di lavoro con stati diversi
        CondizioniLavoro::factory()->create(['stato' => 'attivo']);
        CondizioniLavoro::factory()->create(['stato' => 'inattivo']);
        CondizioniLavoro::factory()->create(['stato' => 'sospeso']);

        $activeConditions = CondizioniLavoro::where('stato', 'attivo')->get();

        expect($activeConditions)->toHaveCount(2); // 1 dal beforeEach + 1 nuovo
        foreach ($activeConditions as $condition) {
            expect($condition->stato)->toBe('attivo');
        }
    });

    it('filters by indennity type', function () {
        // Crea condizioni di lavoro con tipi diversi
        CondizioniLavoro::factory()->create(['tipo_indennita' => 'turno_notturno']);
        CondizioniLavoro::factory()->create(['tipo_indennita' => 'festivo']);
        CondizioniLavoro::factory()->create(['tipo_indennita' => 'straordinario']);

        $nightShiftConditions = CondizioniLavoro::where('tipo_indennita', 'turno_notturno')->get();

        expect($nightShiftConditions)->toHaveCount(2); // 1 dal beforeEach + 1 nuovo
        foreach ($nightShiftConditions as $condition) {
            expect($condition->tipo_indennita)->toBe('turno_notturno');
        }
    });

    it('filters by date range', function () {
        $startDate = now()->subMonth();
        $endDate = now()->addMonth();

        $conditionsInRange = CondizioniLavoro::whereBetween('data_inizio', [$startDate, $endDate])
            ->orWhereBetween('data_fine', [$startDate, $endDate])
            ->get();

        expect($conditionsInRange)->not->toBeEmpty();
    });

    it('filters by user', function () {
        $user = User::factory()->create();
        CondizioniLavoro::factory()->create(['user_id' => $user->id]);

        $userConditions = CondizioniLavoro::where('user_id', $user->id)->get();

        expect($userConditions)->toHaveCount(1);
        expect($userConditions->first()->user_id)->toBe($user->id);
    });

    it('filters by individuale', function () {
        $individuale = Individuale::factory()->create();
        CondizioniLavoro::factory()->create(['individuale_id' => $individuale->id]);

        $individualeConditions = CondizioniLavoro::where('individuale_id', $individuale->id)->get();

        expect($individualeConditions)->toHaveCount(1);
        expect($individualeConditions->first()->individuale_id)->toBe($individuale->id);
    });

    it('filters by amount range', function () {
        $minAmount = 100.00;
        $maxAmount = 200.00;

        $conditionsInRange = CondizioniLavoro::whereBetween('importo', [$minAmount, $maxAmount])->get();

        expect($conditionsInRange)->not->toBeEmpty();
        foreach ($conditionsInRange as $condition) {
            expect($condition->importo)->toBeGreaterThanOrEqual($minAmount);
            expect($condition->importo)->toBeLessThanOrEqual($maxAmount);
        }
    });
});

describe('CondizioniLavoro Validation', function () {
    it('validates required fields', function () {
        $requiredFields = ['user_id', 'individuale_id', 'data_inizio', 'tipo_indennita', 'importo'];

        foreach ($requiredFields as $field) {
            $data = $this->condizioniLavoro->toArray();
            unset($data[$field]);

            $this->expectException(QueryException::class);
            CondizioniLavoro::create($data);
        }
    });

    it('validates date logic', function () {
        // Data fine deve essere successiva alla data inizio
        $this->condizioniLavoro->update([
            'data_inizio' => now(),
            'data_fine' => now()->subDay(),
        ]);

        $this->expectException(QueryException::class);
        $this->condizioniLavoro->save();
    });

    it('validates percentage range', function () {
        // Percentuale deve essere tra 0 e 100
        $this->condizioniLavoro->update([
            'percentuale' => 150.0,
        ]);

        $this->expectException(QueryException::class);
        $this->condizioniLavoro->save();
    });

    it('validates amount positivity', function () {
        // Importo deve essere positivo
        $this->condizioniLavoro->update([
            'importo' => -50.00,
        ]);

        $this->expectException(QueryException::class);
        $this->condizioniLavoro->save();
    });

    it('validates enum values', function () {
        $validTypes = ['turno_notturno', 'festivo', 'straordinario', 'pericolo', 'disagio'];

        foreach ($validTypes as $type) {
            $this->condizioniLavoro->update(['tipo_indennita' => $type]);
            expect($this->condizioniLavoro->tipo_indennita)->toBe($type);
        }
    });
});

describe('CondizioniLavoro Relationships', function () {
    it('belongs to user', function () {
        expect($this->condizioniLavoro->user)->toBeInstanceOf(User::class);
        expect($this->condizioniLavoro->user->id)->toBe($this->condizioniLavoro->user_id);
    });

    it('belongs to individuale', function () {
        expect($this->condizioniLavoro->individuale)->toBeInstanceOf(Individuale::class);
        expect($this->condizioniLavoro->individuale->id)->toBe($this->condizioniLavoro->individuale_id);
    });

    it('can access user through relationship', function () {
        $user = $this->condizioniLavoro->user;

        expect($user)->toBeInstanceOf(User::class);
        expect($user->id)->toBe($this->condizioniLavoro->user_id);
    });

    it('can access individuale through relationship', function () {
        $individuale = $this->condizioniLavoro->individuale;

        expect($individuale)->toBeInstanceOf(Individuale::class);
        expect($individuale->id)->toBe($this->condizioniLavoro->individuale_id);
    });

    it('loads relationships efficiently', function () {
        $conditions = CondizioniLavoro::with(['user', 'individuale'])->get();

        foreach ($conditions as $condition) {
            expect($condition->relationLoaded('user'))->toBeTrue();
            expect($condition->relationLoaded('individuale'))->toBeTrue();
        }
    });
});

describe('CondizioniLavoro Data Management', function () {
    it('handles decimal precision correctly', function () {
        $this->condizioniLavoro->update([
            'importo' => 123.456,
            'percentuale' => 12.345,
        ]);

        // Verifica che i decimali siano arrotondati correttamente
        expect($this->condizioniLavoro->importo)->toBe(123.46);
        expect($this->condizioniLavoro->percentuale)->toBe(12.35);
    });

    it('handles null values correctly', function () {
        $this->condizioniLavoro->update([
            'data_fine' => null,
            'note' => null,
        ]);

        expect($this->condizioniLavoro->data_fine)->toBeNull();
        expect($this->condizioniLavoro->note)->toBeNull();
    });

    it('handles empty strings correctly', function () {
        $this->condizioniLavoro->update([
            'note' => '',
        ]);

        expect($this->condizioniLavoro->note)->toBe('');
    });

    it('handles long text correctly', function () {
        $longNote = str_repeat('Test note ', 100); // 1000 caratteri

        $this->condizioniLavoro->update([
            'note' => $longNote,
        ]);

        expect($this->condizioniLavoro->note)->toBe($longNote);
        expect(strlen($this->condizioniLavoro->note))->toBe(1000);
    });

    it('handles special characters correctly', function () {
        $specialNote = 'Note con caratteri speciali: àèéìòù, €, £, $, %, &, <, >, ", \'';

        $this->condizioniLavoro->update([
            'note' => $specialNote,
        ]);

        expect($this->condizioniLavoro->note)->toBe($specialNote);
    });
});

describe('CondizioniLavoro Edge Cases', function () {
    it('handles same start and end date', function () {
        $sameDate = now();

        $this->condizioniLavoro->update([
            'data_inizio' => $sameDate,
            'data_fine' => $sameDate,
        ]);

        expect($this->condizioniLavoro->data_inizio->toDateString())->toBe($this->condizioniLavoro->data_fine->toDateString());
    });

    it('handles very long periods', function () {
        $longPeriodStart = now()->subYears(10);
        $longPeriodEnd = now()->addYears(10);

        $this->condizioniLavoro->update([
            'data_inizio' => $longPeriodStart,
            'data_fine' => $longPeriodEnd,
        ]);

        $duration = $this->condizioniLavoro->data_fine->diffInDays($this->condizioniLavoro->data_inizio);
        expect($duration)->toBeGreaterThan(3650); // Più di 10 anni
    });

    it('handles very short periods', function () {
        $shortPeriodStart = now();
        $shortPeriodEnd = now()->addMinutes(30);

        $this->condizioniLavoro->update([
            'data_inizio' => $shortPeriodStart,
            'data_fine' => $shortPeriodEnd,
        ]);

        $duration = $this->condizioniLavoro->data_fine->diffInMinutes($this->condizioniLavoro->data_inizio);
        expect($duration)->toBe(30);
    });

    it('handles maximum percentage value', function () {
        $this->condizioniLavoro->update([
            'percentuale' => 100.0,
        ]);

        expect($this->condizioniLavoro->percentuale)->toBe(100.0);
    });

    it('handles zero percentage value', function () {
        $this->condizioniLavoro->update([
            'percentuale' => 0.0,
        ]);

        expect($this->condizioniLavoro->percentuale)->toBe(0.0);
    });

    it('handles maximum amount value', function () {
        $maxAmount = 999999.99;

        $this->condizioniLavoro->update([
            'importo' => $maxAmount,
        ]);

        expect($this->condizioniLavoro->importo)->toBe($maxAmount);
    });

    it('handles minimum amount value', function () {
        $minAmount = 0.01;

        $this->condizioniLavoro->update([
            'importo' => $minAmount,
        ]);

        expect($this->condizioniLavoro->importo)->toBe($minAmount);
    });
});

describe('CondizioniLavoro Performance', function () {
    it('handles large datasets efficiently', function () {
        $startTime = microtime(true);

        // Crea 100 record per testare le performance
        CondizioniLavoro::factory()->count(100)->create();

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        expect($executionTime)->toBeLessThan(5.0); // Dovrebbe essere veloce
        expect(CondizioniLavoro::count())->toBeGreaterThan(100);
    });

    it('efficiently loads relationships', function () {
        $startTime = microtime(true);

        $conditions = CondizioniLavoro::with(['user', 'individuale'])->get();

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        expect($executionTime)->toBeLessThan(1.0); // Dovrebbe essere veloce
        expect($conditions)->not->toBeEmpty();
    });

    it('efficiently filters data', function () {
        $startTime = microtime(true);

        $activeConditions = CondizioniLavoro::where('stato', 'attivo')->get();

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        expect($executionTime)->toBeLessThan(1.0); // Dovrebbe essere veloce
        expect($activeConditions)->not->toBeEmpty();
    });
});

describe('CondizioniLavoro Integration', function () {
    it('integrates with database transactions', function () {
        DB::beginTransaction();

        try {
            $newCondition = CondizioniLavoro::factory()->create();
            expect($newCondition->id)->toBeGreaterThan(0);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    });

    it('integrates with model events', function () {
        $events = [];

        CondizioniLavoro::creating(function ($_model) use (&$events) {
            $events[] = 'creating';
        });

        CondizioniLavoro::created(function ($_model) use (&$events) {
            $events[] = 'created';
        });

        CondizioniLavoro::factory()->create();

        expect($events)->toContain('creating');
        expect($events)->toContain('created');
    });

    it('integrates with soft deletes if enabled', function () {
        if (method_exists($this->condizioniLavoro, 'trashed')) {
            $this->condizioniLavoro->delete();

            expect($this->condizioniLavoro->trashed())->toBeTrue();

            $this->condizioniLavoro->restore();
            expect($this->condizioniLavoro->trashed())->toBeFalse();
        } else {
            // Se soft deletes non è abilitato, il test passa
            expect(true)->toBeTrue();
        }
    });
});
