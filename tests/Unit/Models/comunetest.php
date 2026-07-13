<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Modules\Geo\Models\Comune;
<<<<<<< HEAD
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

use Tests\TestCase;

final class ComuneTest extends TestCase
{
    /** @var array<int, array<string, mixed>> */
    public array $testData = [];

    protected function setUp(): void
    {
        parent::setUp();

        $this->testData = [
            [
                'id' => 1,
                'regione' => 'Lombardia',
                'provincia' => 'Milano',
                'nome' => 'Milano',
                'cap' => '20100',
                'lat' => 45.4642,
                'lng' => 9.1900,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'regione' => 'Lombardia',
                'provincia' => 'Milano',
                'nome' => 'Sesto San Giovanni',
                'cap' => '20099',
                'lat' => 45.5347,
                'lng' => 9.2345,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        File::put(
            base_path('database/content/comuni.json'),
            json_encode($this->testData, JSON_PRETTY_PRINT)
        );
    }

    protected function tearDown(): void
    {
        Cache::forget('sushi_Comune_data');
        File::delete(base_path('database/content/comuni.json'));
        parent::tearDown();
    }

    public function testItCanLoadComuniFromJson(): void
    {
        $comuni = Comune::all();

        Assert::assertCount(2, $comuni);
        /** @var Comune $first */
        $first = $comuni->first();
        Assert::assertSame('Milano', $first->nome);
        /** @var Comune $last */
        $last = $comuni->last();
        Assert::assertSame('Sesto San Giovanni', $last->nome);
    }

    public function testItCanFilterComuniByRegion(): void
    {
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
    }

    public function testItCanFilterComuniByProvince(): void
    {
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
    }

    public function testItCanFilterComuniByCap(): void
    {
        /** @phpstan-ignore-next-line -- Dynamic scope */
        $comuni = Comune::byCap('20100')->get();

        /* @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
        Assert::assertCount(1, $comuni);
        /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
        $first = $comuni->first();
        /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
        Assert::assertSame('20100', $first->cap);
    }

    public function testItCanFilterComuniByName(): void
    {
        /** @phpstan-ignore-next-line -- Dynamic scope */
        $comuni = Comune::byName('Milano')->get();

        /* @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
        Assert::assertCount(1, $comuni);
        /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
        $first = $comuni->first();
        /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
        Assert::assertSame('Milano', $first->nome);
    }

    public function testItCanFilterComuniByExactName(): void
    {
        /** @phpstan-ignore-next-line -- Dynamic scope */
        $comuni = Comune::byExactName('Milano')->get();

        /* @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
        Assert::assertCount(1, $comuni);
        /** @phpstan-ignore-next-line -- $comuni is mixed from ignored scope */
        $first = $comuni->first();
        /* @phpstan-ignore-next-line -- $first is mixed from ignored scope */
        Assert::assertSame('Milano', $first->nome);
    }

    public function testItCanFilterComuniByNameAndProvince(): void
    {
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
    }

    public function testItCanFilterComuniByNameAndRegion(): void
    {
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
    }

    public function testItCanFilterComuniByNameProvinceAndRegion(): void
    {
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
    }

    public function testItCanFilterComuniByNameAndCap(): void
    {
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
    }

    public function testItCanFilterComuniByNameProvinceAndCap(): void
    {
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
    }

    public function testItCanFilterComuniByNameRegionAndCap(): void
    {
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
    }

    public function testItCanFilterComuniByNameProvinceRegionAndCap(): void
    {
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
    }

    public function testItCanCreateANewComune(): void
    {
        $comune = Comune::create([
            'regione' => 'Lombardia',
            'provincia' => 'Milano',
            'nome' => 'Bresso',
            'cap' => '20091',
            'lat' => 45.5389,
            'lng' => 9.1900,
        ]);

        Assert::assertNotNull($comune);
        Assert::assertSame('Bresso', $comune->nome);
        Assert::assertSame('Milano', $comune->provincia);
        Assert::assertSame('Lombardia', $comune->regione);
        Assert::assertSame('20091', $comune->cap);
        Assert::assertSame(45.5389, $comune->lat);
        Assert::assertSame(9.1900, $comune->lng);
    }

    public function testItCanUpdateAnExistingComune(): void
    {
        $comune = Comune::first();
        /* @phpstan-ignore-next-line -- $comune may be null from first() */
        $comune->update([
            'nome' => 'Milano Centro',
            'cap' => '20121',
        ]);

        /* @phpstan-ignore-next-line -- $comune may be null */
        Assert::assertSame('Milano Centro', $comune->nome);
        /* @phpstan-ignore-next-line -- $comune may be null */
        Assert::assertSame('20121', $comune->cap);
    }

    public function testItCanDeleteAnExistingComune(): void
    {
        $comune = Comune::first();
        /** @phpstan-ignore-next-line -- $comune may be null from first() */
        $id = $comune->id;

        /* @phpstan-ignore-next-line -- $comune may be null */
        $comune->delete();

        Assert::assertNull(Comune::find($id));
    }
}
=======

uses(\Modules\Geo\Tests\TestCase::class);
// Laraxot — see module docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.

beforeEach(function (): void {
    // Crea un file JSON di test
    $this->testData = [
        [
            'id' => 1,
            'regione' => 'Lombardia',
            'provincia' => 'Milano',
            'comune' => 'Milano',
            'cap' => '20100',
            'lat' => 45.4642,
            'lng' => 9.1900,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id' => 2,
            'regione' => 'Lombardia',
            'provincia' => 'Milano',
            'comune' => 'Sesto San Giovanni',
            'cap' => '20099',
            'lat' => 45.5347,
            'lng' => 9.2345,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];

    File::put(
        base_path('database/content/comuni.json'),
        json_encode($this->testData, JSON_PRETTY_PRINT)
    );
});

afterEach(function (): void {
    // Pulisci la cache
    Cache::forget('sushi_Comune_data');

    // Rimuovi il file di test
    File::delete(base_path('database/content/comuni.json'));
});

test('it can load comuni from json', function (): void {
    $comuni = Comune::all();

    expect($comuni)->toHaveCount(2);
    expect($comuni[0]->comune)->toBe('Milano');
    expect($comuni[1]->comune)->toBe('Sesto San Giovanni');
});

test('it can filter comuni by region', function (): void {
    $comuni = Comune::byRegion('Lombardia')->get();

    expect($comuni)->toHaveCount(2);
    expect($comuni[0]->regione)->toBe('Lombardia');
    expect($comuni[1]->regione)->toBe('Lombardia');
});

test('it can filter comuni by province', function (): void {
    $comuni = Comune::byProvince('Milano')->get();

    expect($comuni)->toHaveCount(2);
    expect($comuni[0]->provincia)->toBe('Milano');
    expect($comuni[1]->provincia)->toBe('Milano');
});

test('it can filter comuni by cap', function (): void {
    $comuni = Comune::byCap('20100')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->cap)->toBe('20100');
});

test('it can filter comuni by name', function (): void {
    $comuni = Comune::byName('Milano')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
});

test('it can filter comuni by exact name', function (): void {
    $comuni = Comune::byExactName('Milano')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
});

test('it can filter comuni by name and province', function (): void {
    $comuni = Comune::byNameAndProvince('Milano', 'Milano')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
    expect($comuni[0]->provincia)->toBe('Milano');
});

test('it can filter comuni by name and region', function (): void {
    $comuni = Comune::byNameAndRegion('Milano', 'Lombardia')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
    expect($comuni[0]->regione)->toBe('Lombardia');
});

test('it can filter comuni by name province and region', function (): void {
    $comuni = Comune::byNameProvinceAndRegion('Milano', 'Milano', 'Lombardia')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
    expect($comuni[0]->provincia)->toBe('Milano');
    expect($comuni[0]->regione)->toBe('Lombardia');
});

test('it can filter comuni by name and cap', function (): void {
    $comuni = Comune::byNameAndCap('Milano', '20100')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
    expect($comuni[0]->cap)->toBe('20100');
});

test('it can filter comuni by name province and cap', function (): void {
    $comuni = Comune::byNameProvinceAndCap('Milano', 'Milano', '20100')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
    expect($comuni[0]->provincia)->toBe('Milano');
    expect($comuni[0]->cap)->toBe('20100');
});

test('it can filter comuni by name region and cap', function (): void {
    $comuni = Comune::byNameRegionAndCap('Milano', 'Lombardia', '20100')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
    expect($comuni[0]->regione)->toBe('Lombardia');
    expect($comuni[0]->cap)->toBe('20100');
});

test('it can filter comuni by name province region and cap', function (): void {
    $comuni = Comune::byNameProvinceRegionAndCap('Milano', 'Milano', 'Lombardia', '20100')->get();

    expect($comuni)->toHaveCount(1);
    expect($comuni[0]->comune)->toBe('Milano');
    expect($comuni[0]->provincia)->toBe('Milano');
    expect($comuni[0]->regione)->toBe('Lombardia');
    expect($comuni[0]->cap)->toBe('20100');
});

test('it can create a new comune', function (): void {
    $comune = Comune::create([
        'regione' => 'Lombardia',
        'provincia' => 'Milano',
        'comune' => 'Bresso',
        'cap' => '20091',
        'lat' => 45.5389,
        'lng' => 9.1900,
    ]);

    expect($comune->id)->not->toBeNull();
    expect($comune->comune)->toBe('Bresso');
    expect($comune->provincia)->toBe('Milano');
    expect($comune->regione)->toBe('Lombardia');
    expect($comune->cap)->toBe('20091');
    expect($comune->lat)->toBe(45.5389);
    expect($comune->lng)->toBe(9.1900);
});

test('it can update an existing comune', function (): void {
    $comune = Comune::first();
    $comune->update([
        'comune' => 'Milano Centro',
        'cap' => '20121',
    ]);

    expect($comune->comune)->toBe('Milano Centro');
    expect($comune->cap)->toBe('20121');
});

test('it can delete an existing comune', function (): void {
    $comune = Comune::first();
    $id = $comune->id;

    $comune->delete();

    expect(Comune::find($id))->toBeNull();
});
>>>>>>> laraxot/dev
