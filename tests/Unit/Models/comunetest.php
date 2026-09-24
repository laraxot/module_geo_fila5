<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Modules\Geo\Models\Comune;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

/**
 * Alias storico di ComuneTest (nome file lowercase).
 * Stessa business logic: API pubbliche Comune, senza scope fantasma by*.
 *
 * @return list<array<string, mixed>>
 */
function comuneLegacyFixtureRows(): array
{
    return [
        [
            'id' => 1,
            'regione' => 'Lombardia',
            'provincia' => 'Milano',
            'nome' => 'Milano',
            'cap' => '20100',
            'lat' => 45.4642,
            'lng' => 9.1900,
            'created_at' => now()->toIso8601String(),
            'updated_at' => now()->toIso8601String(),
        ],
        [
            'id' => 2,
            'regione' => 'Lombardia',
            'provincia' => 'Milano',
            'nome' => 'Sesto San Giovanni',
            'cap' => '20099',
            'lat' => 45.5347,
            'lng' => 9.2345,
            'created_at' => now()->toIso8601String(),
            'updated_at' => now()->toIso8601String(),
        ],
    ];
}

function comuneLegacyAttrAsString(mixed $value): string
{
    if (is_string($value)) {
        return $value;
    }

    if (is_array($value)) {
        $candidate = $value['nome'] ?? $value[0] ?? null;

        return is_string($candidate) ? $candidate : '';
    }

    return '';
}

beforeEach(function (): void {
    File::ensureDirectoryExists(base_path('database/content'));
    File::put(
        base_path('database/content/comuni.json'),
        json_encode(comuneLegacyFixtureRows(), JSON_PRETTY_PRINT),
    );
});

afterEach(function (): void {
    Cache::forget('sushi_Comune_data');
    File::delete(base_path('database/content/comuni.json'));
});

test('legacy: it can load comuni from json', function (): void {
    $comuni = Comune::all();

    Assert::assertCount(2, $comuni);
    $first = $comuni->first();
    Assert::assertInstanceOf(Comune::class, $first);
    Assert::assertSame('Milano', $first->nome);
});

test('legacy: it can filter comuni by region via query', function (): void {
    $comuni = Comune::query()->where('regione', 'Lombardia')->get();

    Assert::assertCount(2, $comuni);
    $first = $comuni->first();
    Assert::assertInstanceOf(Comune::class, $first);
    Assert::assertSame('Lombardia', comuneLegacyAttrAsString($first->regione));
});

test('legacy: it can filter comuni by province via getComuniByProvincia', function (): void {
    $comuni = Comune::getComuniByProvincia('Milano');

    Assert::assertCount(2, $comuni);
});

test('legacy: it can filter comuni by cap via findByCap', function (): void {
    $comuni = Comune::findByCap('20100');

    Assert::assertCount(1, $comuni);
    $first = $comuni->first();
    Assert::assertInstanceOf(Comune::class, $first);
    Assert::assertSame('20100', comuneLegacyAttrAsString($first->cap));
});

test('legacy: it can find by name', function (): void {
    $comune = Comune::findByNome('Milano');

    Assert::assertInstanceOf(Comune::class, $comune);
    Assert::assertSame('Milano', $comune->nome);
});

test('legacy: it can create a new comune', function (): void {
    $comune = Comune::query()->create([
        'regione' => 'Lombardia',
        'provincia' => 'Milano',
        'nome' => 'Bresso',
        'cap' => '20091',
        'lat' => 45.5389,
        'lng' => 9.1900,
    ]);

    Assert::assertInstanceOf(Comune::class, $comune);
    Assert::assertSame('Bresso', $comune->nome);
});

test('legacy: it can update an existing comune', function (): void {
    $comune = Comune::query()->first();
    Assert::assertInstanceOf(Comune::class, $comune);

    $comune->update([
        'nome' => 'Milano Centro',
        'cap' => '20121',
    ]);

    Assert::assertSame('Milano Centro', $comune->nome);
    Assert::assertSame('20121', comuneLegacyAttrAsString($comune->cap));
});

test('legacy: it can delete an existing comune', function (): void {
    $comune = Comune::query()->first();
    Assert::assertInstanceOf(Comune::class, $comune);
    $id = $comune->id;

    $comune->delete();

    Assert::assertNull(Comune::query()->find($id));
});
