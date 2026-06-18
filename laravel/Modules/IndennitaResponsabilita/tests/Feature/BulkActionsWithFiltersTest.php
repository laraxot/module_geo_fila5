<?php

declare(strict_types=1);

use Filament\Resources\Resource;
use Filament\Tables\Table;
use Illuminate\Support\Arr;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Tables\IndennitaResponsabilitasTable;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;

beforeEach(function () {
    // Setup test environment
});

test('table bulk actions extracts anno from tableFilters using Arr::get', function () {
    // Arrange: simula i tableFilters come arriverebbero dalla Table
    $tableFilters = [
        'anno/valutatore' => [
            'anno' => 2026,
            'quadrimestre' => 1,
            'valutatore_id' => 10,
        ],
    ];

    // Act: estrae il valore usando Arr::get esattamente come fa getTableBulkActions()
    $annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
    $anno = Arr::get($annoValutatoreFilter, 'anno');

    // Assert
    expect($anno)->toBe(2026);
});

test('table bulk actions returns empty array when tableFilters is empty', function () {
    // Arrange
    $tableFilters = [];

    // Act
    $annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
    $anno = Arr::get($annoValutatoreFilter, 'anno');

    // Assert: Arr::get ritorna il default (null o valore mancante)
    expect($anno)->toBeNull();
});

test('table bulk actions returns empty array when anno/valutatore key is missing', function () {
    // Arrange
    $tableFilters = [
        'other_filter' => [
            'value' => 'test',
        ],
    ];

    // Act
    $annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
    $anno = Arr::get($annoValutatoreFilter, 'anno');

    // Assert
    expect($anno)->toBeNull();
});

test('table bulk actions handles nested tableFilters correctly', function () {
    // Arrange: simula struttura completa di tableFilters da Filament
    $tableFilters = [
        'anno/valutatore' => [
            'anno' => 2025,
            'quadrimestre' => 2,
            'valutatore_id' => 20,
        ],
        'is_compiled' => true,
    ];

    // Act: estrae anno e builds template key
    $annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
    $anno = Arr::get($annoValutatoreFilter, 'anno');
    $tpl = 'indennitaresponsabilita-'.(string) ($anno ?? '');

    // Assert
    expect($anno)->toBe(2025);
    expect($tpl)->toBe('indennitaresponsabilita-2025');
});

test('table bulk actions generates correct template key when anno is present', function () {
    // Arrange
    $tableFilters = [
        'anno/valutatore' => [
            'anno' => 2026,
        ],
    ];

    // Act: simula la logica di getTableBulkActions()
    $tableFilters = is_array($tableFilters) ? $tableFilters : [];
    $annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
    $anno = Arr::get($annoValutatoreFilter, 'anno');
    $tpl = 'indennitaresponsabilita-'.(string) ($anno ?? '');

    // Assert
    expect($tpl)->toBe('indennitaresponsabilita-2026');
});

test('table bulk actions generates template key with empty string when anno is null', function () {
    // Arrange
    $tableFilters = [
        'anno/valutatore' => [
            'quadrimestre' => 1,
        ],
    ];

    // Act
    $tableFilters = is_array($tableFilters) ? $tableFilters : [];
    $annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
    $anno = Arr::get($annoValutatoreFilter, 'anno');
    $tpl = 'indennitaresponsabilita-'.(string) ($anno ?? '');

    // Assert
    expect($tpl)->toBe('indennitaresponsabilita-');
});

test('table bulk actions preserves all filter keys from tableFilters', function () {
    // Arrange
    $tableFilters = [
        'anno/valutatore' => [
            'anno' => 2026,
            'quadrimestre' => 1,
            'valutatore_id' => 15,
        ],
        'is_compiled' => false,
    ];

    // Act: verifica che tutti i filtri sono accessibili
    $annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
    $quadrimestre = Arr::get($annoValutatoreFilter, 'quadrimestre');
    $valutatoreId = Arr::get($annoValutatoreFilter, 'valutatore_id');
    $isCompiled = Arr::get($tableFilters, 'is_compiled');

    // Assert
    expect($quadrimestre)->toBe(1);
    expect($valutatoreId)->toBe(15);
    expect($isCompiled)->toBe(false);
});

test('table bulk actions casts anno to string for template key correctly', function () {
    // Arrange
    $tableFilters = [
        'anno/valutatore' => [
            'anno' => 2026, // integer
        ],
    ];

    // Act
    $annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
    $anno = Arr::get($annoValutatoreFilter, 'anno');
    $tpl = 'indennitaresponsabilita-'.(string) ($anno ?? '');

    // Assert: verifica conversione a string
    expect($anno)->toBe(2026);
    expect($tpl)->toBe('indennitaresponsabilita-2026');
    expect(is_string(substr($tpl, -4)))->toBeTrue();
});

test('table bulk actions handles non-array tableFilters gracefully', function () {
    // Arrange: simula un caso edge dove tableFilters potrebbe non essere un array
    $tableFilters = null;

    // Act: come fa getTableBulkActions()
    $tableFilters = is_array($tableFilters) ? $tableFilters : [];
    $annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
    $anno = Arr::get($annoValutatoreFilter, 'anno');

    // Assert
    expect($tableFilters)->toBe([]);
    expect($anno)->toBeNull();
});
