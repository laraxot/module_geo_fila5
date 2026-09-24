<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Modules\Geo\Models\Comune;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

/**
 * Normalizza attributi Comune che in JSON sono stringhe ma in phpdoc risultano array|string.
 */
function comuneAttrAsString(mixed $value): string
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

/**
 * @return list<array<string, mixed>>
 */
function comuneFixtureRows(): array
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

beforeEach(function (): void {
    File::ensureDirectoryExists(base_path('database/content'));
    File::put(
        base_path('database/content/comuni.json'),
        json_encode(comuneFixtureRows(), JSON_PRETTY_PRINT),
    );
});

afterEach(function (): void {
    Cache::forget('sushi_Comune_data');
    File::delete(base_path('database/content/comuni.json'));
});

it('can load comuni from json', function (): void {
    $comuni = Comune::all();

    Assert::assertCount(2, $comuni);
    $first = $comuni->first();
    Assert::assertInstanceOf(Comune::class, $first);
    Assert::assertSame('Milano', $first->nome);
    $last = $comuni->last();
    Assert::assertInstanceOf(Comune::class, $last);
    Assert::assertSame('Sesto San Giovanni', $last->nome);
});

it('can filter comuni by region', function (): void {
    $comuni = Comune::query()->where('regione', 'Lombardia')->get();

    Assert::assertCount(2, $comuni);
    foreach ($comuni as $comune) {
        Assert::assertInstanceOf(Comune::class, $comune);
        Assert::assertSame('Lombardia', comuneAttrAsString($comune->regione));
    }
});

it('can filter comuni by province', function (): void {
    $comuni = Comune::getComuniByProvincia('Milano');

    Assert::assertCount(2, $comuni);
    foreach ($comuni as $comune) {
        Assert::assertInstanceOf(Comune::class, $comune);
        Assert::assertSame('Milano', comuneAttrAsString($comune->provincia));
    }
});

it('can filter comuni by cap', function (): void {
    $comuni = Comune::findByCap('20100');

    Assert::assertCount(1, $comuni);
    $first = $comuni->first();
    Assert::assertInstanceOf(Comune::class, $first);
    Assert::assertSame('20100', comuneAttrAsString($first->cap));
});

it('can find comune by name', function (): void {
    $comune = Comune::findByNome('Milano');

    Assert::assertInstanceOf(Comune::class, $comune);
    Assert::assertSame('Milano', $comune->nome);
});

it('can find comune by name case insensitive', function (): void {
    $comune = Comune::findByNome('milano');

    Assert::assertInstanceOf(Comune::class, $comune);
    Assert::assertSame('Milano', $comune->nome);
});

it('can filter comuni by name and province', function (): void {
    $comuni = Comune::query()
        ->where('nome', 'Milano')
        ->where('provincia', 'Milano')
        ->get();

    Assert::assertCount(1, $comuni);
    $first = $comuni->first();
    Assert::assertInstanceOf(Comune::class, $first);
    Assert::assertSame('Milano', $first->nome);
    Assert::assertSame('Milano', comuneAttrAsString($first->provincia));
});

it('can filter comuni by name and region', function (): void {
    $comuni = Comune::query()
        ->where('nome', 'Milano')
        ->where('regione', 'Lombardia')
        ->get();

    Assert::assertCount(1, $comuni);
    $first = $comuni->first();
    Assert::assertInstanceOf(Comune::class, $first);
    Assert::assertSame('Milano', $first->nome);
    Assert::assertSame('Lombardia', comuneAttrAsString($first->regione));
});

it('can filter comuni by name province and region', function (): void {
    $comuni = Comune::query()
        ->where('nome', 'Milano')
        ->where('provincia', 'Milano')
        ->where('regione', 'Lombardia')
        ->get();

    Assert::assertCount(1, $comuni);
    $first = $comuni->first();
    Assert::assertInstanceOf(Comune::class, $first);
    Assert::assertSame('Milano', $first->nome);
    Assert::assertSame('Milano', comuneAttrAsString($first->provincia));
    Assert::assertSame('Lombardia', comuneAttrAsString($first->regione));
});

it('can filter comuni by name and cap', function (): void {
    $comuni = Comune::query()
        ->where('nome', 'Milano')
        ->where('cap', 'like', '%20100%')
        ->get();

    Assert::assertCount(1, $comuni);
    $first = $comuni->first();
    Assert::assertInstanceOf(Comune::class, $first);
    Assert::assertSame('Milano', $first->nome);
    Assert::assertSame('20100', comuneAttrAsString($first->cap));
});

it('can create a new comune', function (): void {
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
    Assert::assertSame('Milano', comuneAttrAsString($comune->provincia));
    Assert::assertSame('Lombardia', comuneAttrAsString($comune->regione));
    Assert::assertSame('20091', comuneAttrAsString($comune->cap));
    Assert::assertSame(45.5389, $comune->lat);
    Assert::assertSame(9.1900, $comune->lng);
});

it('can update an existing comune', function (): void {
    $comune = Comune::query()->first();
    Assert::assertInstanceOf(Comune::class, $comune);

    $comune->update([
        'nome' => 'Milano Centro',
        'cap' => '20121',
    ]);

    Assert::assertSame('Milano Centro', $comune->nome);
    Assert::assertSame('20121', comuneAttrAsString($comune->cap));
});

it('can delete an existing comune', function (): void {
    $comune = Comune::query()->first();
    Assert::assertInstanceOf(Comune::class, $comune);
    $id = $comune->id;

    $comune->delete();

    Assert::assertNull(Comune::query()->find($id));
});
