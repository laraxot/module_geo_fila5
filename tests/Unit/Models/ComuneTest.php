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
    /** @phpstan-ignore-next-line -- Dynamic scope */
    $comuni = Comune::byRegion('Lombardia')->get();

    /* @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    Assert::assertCount(2, $comuni);
    /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    $first = $comuni->first();
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Lombardia', $first->regione);
    /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    $last = $comuni->last();
    /* @phpstan-ignore-next-line -- $last is mixed from ignored scope */
    Assert::assertSame('Lombardia', $last->regione);
});

it('can filter comuni by province', function (): void {
    /** @phpstan-ignore-next-line -- Dynamic scope */
    $comuni = Comune::byProvince('Milano')->get();

    /* @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    Assert::assertCount(2, $comuni);
    /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    $first = $comuni->first();
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Milano', $first->provincia);
    /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    $last = $comuni->last();
    /* @phpstan-ignore-next-line -- $last is mixed from ignored scope */
    Assert::assertSame('Milano', $last->provincia);
});

it('can filter comuni by cap', function (): void {
    /** @phpstan-ignore-next-line -- Dynamic scope */
    $comuni = Comune::byCap('20100')->get();

    /* @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    Assert::assertCount(1, $comuni);
    /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    $first = $comuni->first();
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('20100', $first->cap);
});

it('can filter comuni by name', function (): void {
    /** @phpstan-ignore-next-line -- Dynamic scope */
    $comuni = Comune::byName('Milano')->get();

    /* @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    Assert::assertCount(1, $comuni);
    /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    $first = $comuni->first();
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Milano', $first->nome);
});

it('can filter comuni by exact name', function (): void {
    /** @phpstan-ignore-next-line -- Dynamic scope */
    $comuni = Comune::byExactName('Milano')->get();

    /* @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    Assert::assertCount(1, $comuni);
    /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    $first = $comuni->first();
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Milano', $first->nome);
});

it('can filter comuni by name and province', function (): void {
    /** @phpstan-ignore-next-line -- Dynamic scope */
    $comuni = Comune::byNameAndProvince('Milano', 'Milano')->get();

    /* @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    Assert::assertCount(1, $comuni);
    /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    $first = $comuni->first();
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Milano', $first->nome);
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Milano', $first->provincia);
});

it('can filter comuni by name and region', function (): void {
    /** @phpstan-ignore-next-line -- Dynamic scope */
    $comuni = Comune::byNameAndRegion('Milano', 'Lombardia')->get();

    /* @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    Assert::assertCount(1, $comuni);
    /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    $first = $comuni->first();
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Milano', $first->nome);
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Lombardia', $first->regione);
});

it('can filter comuni by name, province and region', function (): void {
    /** @phpstan-ignore-next-line -- Dynamic scope */
    $comuni = Comune::byNameProvinceAndRegion('Milano', 'Milano', 'Lombardia')->get();

    /* @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    Assert::assertCount(1, $comuni);
    /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    $first = $comuni->first();
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Milano', $first->nome);
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Milano', $first->provincia);
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Lombardia', $first->regione);
});

it('can filter comuni by name and cap', function (): void {
    /** @phpstan-ignore-next-line -- Dynamic scope */
    $comuni = Comune::byNameAndCap('Milano', '20100')->get();

    /* @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    Assert::assertCount(1, $comuni);
    /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    $first = $comuni->first();
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Milano', $first->nome);
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('20100', $first->cap);
});

it('can filter comuni by name, province and cap', function (): void {
    /** @phpstan-ignore-next-line -- Dynamic scope */
    $comuni = Comune::byNameProvinceAndCap('Milano', 'Milano', '20100')->get();

    /* @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    Assert::assertCount(1, $comuni);
    /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    $first = $comuni->first();
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Milano', $first->nome);
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Milano', $first->provincia);
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('20100', $first->cap);
});

it('can filter comuni by name, region and cap', function (): void {
    /** @phpstan-ignore-next-line -- Dynamic scope */
    $comuni = Comune::byNameRegionAndCap('Milano', 'Lombardia', '20100')->get();

    /* @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    Assert::assertCount(1, $comuni);
    /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    $first = $comuni->first();
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Milano', $first->nome);
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Lombardia', $first->regione);
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('20100', $first->cap);
});

it('can filter comuni by name, province, region and cap', function (): void {
    /** @phpstan-ignore-next-line -- Dynamic scope */
    $comuni = Comune::byNameProvinceRegionAndCap('Milano', 'Milano', 'Lombardia', '20100')->get();

    /* @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    Assert::assertCount(1, $comuni);
    /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
    $first = $comuni->first();
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Milano', $first->nome);
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Milano', $first->provincia);
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('Lombardia', $first->regione);
    /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
    Assert::assertSame('20100', $first->cap);
});

it('can create a new comune', function (): void {
    $comune = Comune::create([
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

    /* @phpstan-ignore-next-line -- $comune may be null */
    Assert::assertSame('Milano Centro', $comune->nome);
    /* @phpstan-ignore-next-line -- $comune may be null */
    Assert::assertSame('20121', $comune->cap);
});

it('can delete an existing comune', function (): void {
    $comune = Comune::first();
    /** @phpstan-ignore-next-line -- $comune may be null from first() */
    $id = $comune->id;

    /* @phpstan-ignore-next-line -- $comune may be null */
    $comune->delete();

    Assert::assertNull(Comune::find($id));
});
