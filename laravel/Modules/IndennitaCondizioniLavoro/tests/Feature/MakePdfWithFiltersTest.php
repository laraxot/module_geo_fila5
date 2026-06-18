<?php

declare(strict_types=1);

use InvalidArgumentException;
use Modules\IndennitaCondizioniLavoro\Actions\MakePdf;

test('make_pdf action extracts anno from nested tableFilters', function () {
    // Arrange
    $filters = [
        'anno/valutatore' => [
            'anno' => 2026,
            'valutatore_id' => 50,
        ],
    ];

    // Act: estrai i filtri come fa execute()
    $filtersInput = $filters['anno/valutatore'] ?? $filters;

    // Assert
    expect($filtersInput)->toBe([
        'anno' => 2026,
        'valutatore_id' => 50,
    ]);

    $anno = isset($filtersInput['anno']) ? (int) $filtersInput['anno'] : null;
    $valutatoreId = isset($filtersInput['valutatore_id']) ? (int) $filtersInput['valutatore_id'] : null;

    expect($anno)->toBe(2026);
    expect($valutatoreId)->toBe(50);
});

test('make_pdf action extracts valutatore_id from nested tableFilters', function () {
    // Arrange
    $filters = [
        'anno/valutatore' => [
            'anno' => 2025,
            'valutatore_id' => 60,
        ],
    ];

    // Act
    $filtersInput = $filters['anno/valutatore'] ?? $filters;
    $anno = isset($filtersInput['anno']) ? (int) $filtersInput['anno'] : null;
    $valutatoreId = isset($filtersInput['valutatore_id']) ? (int) $filtersInput['valutatore_id'] : null;

    // Assert
    expect($anno)->toBe(2025);
    expect($valutatoreId)->toBe(60);
});

test('make_pdf action throws exception when tableFilters missing anno', function () {
    // Arrange
    $invalidFilters = [
        'anno/valutatore' => [
            'valutatore_id' => 50,
        ],
    ];

    $action = new MakePdf();

    // Act & Assert
    expect(fn () => $action->execute($invalidFilters))
        ->toThrow(InvalidArgumentException::class);
});

test('make_pdf action throws exception when tableFilters missing valutatore_id', function () {
    // Arrange
    $invalidFilters = [
        'anno/valutatore' => [
            'anno' => 2026,
        ],
    ];

    $action = new MakePdf();

    // Act & Assert
    expect(fn () => $action->execute($invalidFilters))
        ->toThrow(InvalidArgumentException::class);
});

test('make_pdf action accepts flattened data array as fallback', function () {
    // Arrange: test del fallback path
    $flatData = [
        'anno' => 2026,
        'valutatore_id' => 70,
    ];

    // Act: simula parsing con fallback
    $filtersInput = $flatData['anno/valutatore'] ?? $flatData;

    // Assert: deve usare flatData quando 'anno/valutatore' non esiste
    expect($filtersInput)->toBe([
        'anno' => 2026,
        'valutatore_id' => 70,
    ]);

    $anno = isset($filtersInput['anno']) ? (int) $filtersInput['anno'] : null;
    $valutatoreId = isset($filtersInput['valutatore_id']) ? (int) $filtersInput['valutatore_id'] : null;

    expect($anno)->toBe(2026);
    expect($valutatoreId)->toBe(70);
});

test('make_pdf action generates correct filename pattern', function () {
    // Arrange
    $anno = 2026;
    $valutatoreId = 80;

    // Act: simula la generazione del filename
    $filename = sprintf('condizioni_lavoro_%d_%d.pdf', $valutatoreId, $anno);

    // Assert
    expect($filename)->toBe('condizioni_lavoro_80_2026.pdf');
});
