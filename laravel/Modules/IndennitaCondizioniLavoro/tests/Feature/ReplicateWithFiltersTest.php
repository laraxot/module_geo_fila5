<?php

declare(strict_types=1);

use Filament\Notifications\Notification;
use Modules\IndennitaCondizioniLavoro\Actions\ReplicateIndennita;
use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    // Reset database state
    DB::table('condizioni_laboros')->truncate();
});

test('replicate action receives tableFilters parameter correctly', function () {
    // Arrange: crea dati di test
    $anno = 2026;
    $quadrimestre = 2;

    // Crea record per il quadrimestre precedente (Q1)
    $sourceRecord = CondizioniLavoro::create([
        'anno' => $anno,
        'quadrimestre' => 1,
        'ente' => 1,
        'matr' => 100,
        'email' => 'test@example.com',
        'cognome' => 'Rossi',
        'nome' => 'Mario',
    ]);

    // Crea record per il quadrimestre target (Q2)
    $targetRecord = CondizioniLavoro::create([
        'anno' => $anno,
        'quadrimestre' => 2,
        'ente' => 1,
        'matr' => 100,
        'email' => 'test@example.com',
        'cognome' => 'Rossi',
        'nome' => 'Mario',
    ]);

    // Mock la relazione indennitaTipoDettaglio
    $sourceRecord->indennitaTipoDettaglio()->sync([1, 2, 3]);

    // Act: chiama action con filters via tableFilters
    $filters = [
        'anno/valutatore' => [
            'anno' => $anno,
            'quadrimestre' => $quadrimestre,
        ],
    ];

    $action = new ReplicateIndennita();

    // Expect notification to be sent
    Notification::fake();

    $action->execute($filters);

    // Assert: verifica che i dati vengono elaborati
    Notification::assertSent(function ($notification) {
        return str_contains($notification->title, 'Replicate');
    });
});

test('replicate action extracts anno and quadrimestre from nested tableFilters', function () {
    // Arrange
    $anno = 2025;
    $quadrimestre = 3;

    $sourceRecord = CondizioniLavoro::create([
        'anno' => $anno,
        'quadrimestre' => 2,
        'ente' => 1,
        'matr' => 200,
        'email' => 'test2@example.com',
        'cognome' => 'Bianchi',
        'nome' => 'Luigi',
    ]);

    $sourceRecord->indennitaTipoDettaglio()->sync([1]);

    // Act
    $filters = [
        'anno/valutatore' => [
            'anno' => $anno,
            'quadrimestre' => $quadrimestre,
        ],
    ];

    $action = new ReplicateIndennita();

    Notification::fake();
    $action->execute($filters);

    // Assert: verifica che il record precedente (Q2) è stato cercato
    Notification::assertSent(function ($notification) {
        // Se la notifica contiene "Replicate", significa l'action ha processato i dati
        return str_contains($notification->title, 'Replicate 1 record');
    });
});

test('replicate action throws exception when tableFilters missing required keys', function () {
    // Arrange
    $invalidFilters = [
        'anno/valutatore' => [
            'anno' => 2026,
            // 'quadrimestre' => manca!
        ],
    ];

    $action = new ReplicateIndennita();

    // Act & Assert
    expect(fn () => $action->execute($invalidFilters))
        ->toThrow(InvalidArgumentException::class);
});

test('replicate action accepts flattened data array as fallback', function () {
    // Arrange
    $anno = 2026;
    $quadrimestre = 1;

    $sourceRecord = CondizioniLavoro::create([
        'anno' => $anno,
        'quadrimestre' => 0,
        'ente' => 1,
        'matr' => 300,
        'email' => 'test3@example.com',
        'cognome' => 'Verdi',
        'nome' => 'Giuseppe',
    ]);

    $sourceRecord->indennitaTipoDettaglio()->sync([2, 3]);

    // Act: passa dati direttamente (fallback path)
    $flatData = [
        'anno' => $anno,
        'quadrimestre' => $quadrimestre,
    ];

    $action = new ReplicateIndennita();

    Notification::fake();
    $action->execute($flatData);

    // Assert
    Notification::assertSent(function ($notification) {
        return str_contains($notification->title, 'Replicate');
    });
});
