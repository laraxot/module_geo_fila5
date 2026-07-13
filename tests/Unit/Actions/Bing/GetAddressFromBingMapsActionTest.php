<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Bing;

<<<<<<< HEAD
use Illuminate\Support\Facades\Http;
=======
>>>>>>> laraxot/dev
use Modules\Geo\Actions\Bing\GetAddressFromBingMapsAction;
use Modules\Geo\Datas\Geocoding\AddressData;
use Modules\Geo\Exceptions\InvalidLocationException;
use Modules\Geo\Tests\LightTestCase;
<<<<<<< HEAD
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);
=======

uses(LightTestCase::class);
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.

>>>>>>> laraxot/dev
it('throws exception when api key is not configured', function (): void {
    config(['services.bing.maps_api_key' => null]);

    $action = new GetAddressFromBingMapsAction();
<<<<<<< HEAD
    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('API key di Bing Maps non configurata', $exception->getMessage());
    }
=======
    expect(fn () => $action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'API key di Bing Maps non configurata');
>>>>>>> laraxot/dev
});

it('throws exception for invalid latitude range', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    $action = new GetAddressFromBingMapsAction();
<<<<<<< HEAD
    try {
        $action->execute(91.0, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException) {
    }
=======
    expect(fn () => $action->execute(91.0, 9.1900))
        ->toThrow(InvalidLocationException::class);
>>>>>>> laraxot/dev
});

it('throws exception for invalid longitude range', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    $action = new GetAddressFromBingMapsAction();
<<<<<<< HEAD
    try {
        $action->execute(45.0, 181.0);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException) {
    }
=======
    expect(fn () => $action->execute(45.0, 181.0))
        ->toThrow(InvalidLocationException::class);
>>>>>>> laraxot/dev
});

it('throws exception when api response is not successful', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response(['statusCode' => 500], 500),
    ]);

    $action = new GetAddressFromBingMapsAction();
<<<<<<< HEAD
    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Richiesta a Bing Maps fallita', $exception->getMessage());
    }
=======
    expect(fn () => $action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Richiesta a Bing Maps fallita');
>>>>>>> laraxot/dev
});

it('throws exception when api response is not valid json', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response('not valid json', 200),
    ]);

    $action = new GetAddressFromBingMapsAction();
<<<<<<< HEAD
    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Risposta JSON non valida', $exception->getMessage());
    }
=======
    expect(fn () => $action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Risposta JSON non valida');
>>>>>>> laraxot/dev
});

it('throws exception when no results in response', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'resourceSets' => [[
                'resources' => [],
            ]],
        ], 200),
    ]);

    $action = new GetAddressFromBingMapsAction();
<<<<<<< HEAD
    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Nessun risultato trovato', $exception->getMessage());
    }
=======
    expect(fn () => $action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Nessun risultato trovato');
>>>>>>> laraxot/dev
});

it('throws exception when point is missing in response', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'resourceSets' => [[
                'resources' => [[
                    'address' => ['locality' => 'Milano'],
                ]],
            ]],
        ], 200),
    ]);

    $action = new GetAddressFromBingMapsAction();
<<<<<<< HEAD
    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Point mancante', $exception->getMessage());
    }
=======
    expect(fn () => $action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Point mancante');
>>>>>>> laraxot/dev
});

it('throws exception when coordinates are missing in response', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'resourceSets' => [[
                'resources' => [[
                    'point' => [],
                    'address' => ['locality' => 'Milano'],
                ]],
            ]],
        ], 200),
    ]);

    $action = new GetAddressFromBingMapsAction();
<<<<<<< HEAD
    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Coordinate mancanti', $exception->getMessage());
    }
=======
    expect(fn () => $action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Coordinate mancanti');
>>>>>>> laraxot/dev
});

it('throws exception when address is missing in response', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'resourceSets' => [[
                'resources' => [[
                    'point' => ['coordinates' => [45.4642, 9.1900]],
                ]],
            ]],
        ], 200),
    ]);

    $action = new GetAddressFromBingMapsAction();
<<<<<<< HEAD
    try {
        $action->execute(45.4642, 9.1900);
        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Indirizzo mancante', $exception->getMessage());
    }
=======
    expect(fn () => $action->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Indirizzo mancante');
>>>>>>> laraxot/dev
});

it('returns address data for valid coordinates', function (): void {
    config(['services.bing.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'resourceSets' => [[
                'resources' => [[
                    'point' => ['coordinates' => [45.4642, 9.1900]],
                    'address' => [
                        'countryRegion' => 'Italia',
                        'adminDistrict' => 'Lombardia',
                        'adminDistrict2' => 'Milano',
                        'locality' => 'Milano',
                        'postalCode' => '20100',
                        'addressLine' => 'Via Roma 1',
                        'countryRegionIso2' => 'IT',
                    ],
                ]],
            ]],
        ], 200),
    ]);

    $action = new GetAddressFromBingMapsAction();
    $result = $action->execute(45.4642, 9.1900);

<<<<<<< HEAD
    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame(45.4642, $result->latitude);

    Assert::assertSame(9.1900, $result->longitude);

    Assert::assertSame('Italia', $result->country);

    Assert::assertSame('Milano', $result->city);

    Assert::assertSame('20100', $result->postal_code);

    Assert::assertSame('Via Roma 1', $result->street);

    Assert::assertSame('Lombardia', $result->state);

    Assert::assertSame('IT', $result->country_code);
=======
    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900)
        ->and($result->country)->toBe('Italia')
        ->and($result->city)->toBe('Milano')
        ->and($result->postal_code)->toBe('20100')
        ->and($result->street)->toBe('Via Roma 1')
        ->and($result->state)->toBe('Lombardia')
        ->and($result->country_code)->toBe('IT');
>>>>>>> laraxot/dev
});
