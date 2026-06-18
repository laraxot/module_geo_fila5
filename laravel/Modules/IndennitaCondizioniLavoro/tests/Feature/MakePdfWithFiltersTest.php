<?php

declare(strict_types=1);

use Modules\IndennitaCondizioniLavoro\Actions\MakePdf;
use Modules\IndennitaCondizioniLavoro\Models\CondizioniLavoro;
use Modules\IndennitaCondizioniLavoro\Models\StabiDirigente;
use Illuminate\Support\Facades\DB;

beforeEach(function () {
    // Reset database state
    DB::table('condizioni_laboros')->truncate();
    DB::table('stabi_dirigentes')->truncate();
});

test('make_pdf action receives tableFilters parameter with anno and valutatore_id', function () {
    // Arrange: crea dati di test
    $anno = 2026;
    $valutatoreId = 50;

    CondizioniLavoro::create([
        'anno' => $anno,
        'quadrimestre' => 1,
        'ente' => 1,
        'matr' => 100,
        'email' => 'pdf@example.com',
        'cognome' => 'Rossi',
        'nome' => 'Mario',
        'valutatore_id' => $valutatoreId,
    ]);

    StabiDirigente::create([
        'id' => $valutatoreId,
        'valutatore_id' => $valutatoreId,
        'anno' => $anno,
        'nome_diri' => 'Dott. Rossi',
        'ente' => 1,
        'matr' => 50,
    ]);

    // Act: chiama action con tableFilters
    $filters = [
        'anno/valutatore' => [
            'anno' => $anno,
            'valutatore_id' => $valutatoreId,
        ],
    ];

    $action = new MakePdf();
    $response = $action->execute($filters);

    // Assert: verifica che è stata ritornata una risposta (StreamedResponse)
    expect($response)->toBeInstanceOf(\Symfony\Component\HttpFoundation\StreamedResponse::class);
});

test('make_pdf action extracts anno and valutatore_id from nested tableFilters', function () {
    // Arrange
    $anno = 2025;
    $valutatoreId = 60;

    CondizioniLavoro::create([
        'anno' => $anno,
        'quadrimestre' => 2,
        'ente' => 1,
        'matr' => 200,
        'email' => 'pdf2@example.com',
        'cognome' => 'Bianchi',
        'nome' => 'Luigi',
        'valutatore_id' => $valutatoreId,
    ]);

    StabiDirigente::create([
        'id' => $valutatoreId,
        'valutatore_id' => $valutatoreId,
        'anno' => $anno,
        'nome_diri' => 'Ing. Bianchi',
        'ente' => 1,
        'matr' => 60,
    ]);

    // Act
    $filters = [
        'anno/valutatore' => [
            'anno' => $anno,
            'valutatore_id' => $valutatoreId,
        ],
    ];

    $action = new MakePdf();
    $response = $action->execute($filters);

    // Assert
    expect($response)->toBeInstanceOf(\Symfony\Component\HttpFoundation\StreamedResponse::class);
    expect($response->headers->get('Content-Disposition'))->toContain('condizioni_lavoro_'.$valutatoreId.'_'.$anno);
});

test('make_pdf action throws exception when tableFilters missing anno', function () {
    // Arrange
    $invalidFilters = [
        'anno/valutatore' => [
            // 'anno' => manca!
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
            // 'valutatore_id' => manca!
        ],
    ];

    $action = new MakePdf();

    // Act & Assert
    expect(fn () => $action->execute($invalidFilters))
        ->toThrow(InvalidArgumentException::class);
});

test('make_pdf action accepts flattened data array as fallback', function () {
    // Arrange
    $anno = 2026;
    $valutatoreId = 70;

    CondizioniLavoro::create([
        'anno' => $anno,
        'quadrimestre' => 1,
        'ente' => 1,
        'matr' => 300,
        'email' => 'pdf3@example.com',
        'cognome' => 'Verdi',
        'nome' => 'Giuseppe',
        'valutatore_id' => $valutatoreId,
    ]);

    StabiDirigente::create([
        'id' => $valutatoreId,
        'valutatore_id' => $valutatoreId,
        'anno' => $anno,
        'nome_diri' => 'Prof. Verdi',
        'ente' => 1,
        'matr' => 70,
    ]);

    // Act: passa dati direttamente (fallback path)
    $flatData = [
        'anno' => $anno,
        'valutatore_id' => $valutatoreId,
    ];

    $action = new MakePdf();
    $response = $action->execute($flatData);

    // Assert
    expect($response)->toBeInstanceOf(\Symfony\Component\HttpFoundation\StreamedResponse::class);
});

test('make_pdf action generates correct filename with valutatore_id and anno', function () {
    // Arrange
    $anno = 2026;
    $valutatoreId = 80;

    CondizioniLavoro::create([
        'anno' => $anno,
        'quadrimestre' => 1,
        'ente' => 1,
        'matr' => 400,
        'email' => 'pdf4@example.com',
        'cognome' => 'Neri',
        'nome' => 'Antonio',
        'valutatore_id' => $valutatoreId,
    ]);

    StabiDirigente::create([
        'id' => $valutatoreId,
        'valutatore_id' => $valutatoreId,
        'anno' => $anno,
        'nome_diri' => 'Dr. Neri',
        'ente' => 1,
        'matr' => 80,
    ]);

    // Act
    $filters = [
        'anno/valutatore' => [
            'anno' => $anno,
            'valutatore_id' => $valutatoreId,
        ],
    ];

    $action = new MakePdf();
    $response = $action->execute($filters);

    // Assert: verifica che il filename contenga i parametri corretti
    $expectedFilename = sprintf('condizioni_lavoro_%d_%d.pdf', $valutatoreId, $anno);
    expect($response->headers->get('Content-Disposition'))->toContain($expectedFilename);
});
