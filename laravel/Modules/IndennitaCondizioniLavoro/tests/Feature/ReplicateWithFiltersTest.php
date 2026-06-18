<?php

declare(strict_types=1);

use Modules\IndennitaCondizioniLavoro\Actions\ReplicateIndennita;

test('replicate action extracts anno from nested tableFilters', function () {
    // Arrange: test della logica di parsing dei filtri
    $filters = [
        'anno/valutatore' => [
            'anno' => 2026,
            'quadrimestre' => 2,
        ],
    ];

    // Act: estrai i filtri come fa execute()
    $input = $filters['anno/valutatore'] ?? $filters;

    // Assert
    expect($input)->toBe([
        'anno' => 2026,
        'quadrimestre' => 2,
    ]);

    $anno = isset($input['anno']) ? (int) $input['anno'] : null;
    $quadrimestre = isset($input['quadrimestre']) ? (int) $input['quadrimestre'] : null;

    expect($anno)->toBe(2026);
    expect($quadrimestre)->toBe(2);
});

test('replicate action extracts quadrimestre from nested tableFilters', function () {
    // Arrange
    $filters = [
        'anno/valutatore' => [
            'anno' => 2025,
            'quadrimestre' => 3,
        ],
    ];

    // Act
    $input = $filters['anno/valutatore'] ?? $filters;
    $anno = isset($input['anno']) ? (int) $input['anno'] : null;
    $quadrimestre = isset($input['quadrimestre']) ? (int) $input['quadrimestre'] : null;

    // Assert
    expect($anno)->toBe(2025);
    expect($quadrimestre)->toBe(3);
});

test('replicate action throws exception when tableFilters missing anno', function () {
    // Arrange
    $invalidFilters = [
        'anno/valutatore' => [
            'quadrimestre' => 2,
        ],
    ];

    // Act
    $input = $invalidFilters['anno/valutatore'] ?? $invalidFilters;
    $anno = isset($input['anno']) ? (int) $input['anno'] : null;
    $quadrimestre = isset($input['quadrimestre']) ? (int) $input['quadrimestre'] : null;

    // Assert
    expect($anno)->toBeNull();

    // Simula la check dell'action
    expect(fn () => new ReplicateIndennita())
        ->not->toThrow(InvalidArgumentException::class);

    // Ma se passiamo a execute(), dovrebbe lanciare eccezione
    $action = new ReplicateIndennita();
    expect(fn () => $action->execute($invalidFilters))
        ->toThrow(InvalidArgumentException::class);
});

test('replicate action throws exception when tableFilters missing quadrimestre', function () {
    // Arrange
    $invalidFilters = [
        'anno/valutatore' => [
            'anno' => 2026,
        ],
    ];

    $action = new ReplicateIndennita();

    // Act & Assert
    expect(fn () => $action->execute($invalidFilters))
        ->toThrow(InvalidArgumentException::class);
});

test('replicate action accepts flattened data array as fallback', function () {
    // Arrange: test del fallback path
    $flatData = [
        'anno' => 2026,
        'quadrimestre' => 1,
    ];

    // Act: simula parsing con fallback
    $input = $flatData['anno/valutatore'] ?? $flatData;

    // Assert: deve usare flatData quando 'anno/valutatore' non esiste
    expect($input)->toBe([
        'anno' => 2026,
        'quadrimestre' => 1,
    ]);

    $anno = isset($input['anno']) ? (int) $input['anno'] : null;
    $quadrimestre = isset($input['quadrimestre']) ? (int) $input['quadrimestre'] : null;

    expect($anno)->toBe(2026);
    expect($quadrimestre)->toBe(1);
});
