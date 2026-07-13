<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Mapbox;

<<<<<<< HEAD
=======
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);
// Laraxot — see module docs/wiki for domain contract.
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
use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\Mapbox\GetAddressFromMapboxLatLngAction;
use Modules\Geo\Datas\Geocoding\AddressData;
use Modules\Geo\Exceptions\InvalidLocationException;
<<<<<<< HEAD
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);
it('throws exception for invalid latitude below -90', function (): void {
    $action = new GetAddressFromMapboxLatLngAction();

    try {
        $action->execute(-91.0, 9.1900);

        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertStringContainsString('Latitudine non valida', $exception->getMessage());
    }
});

it('throws exception for invalid latitude above 90', function (): void {
    $action = new GetAddressFromMapboxLatLngAction();

    try {
        $action->execute(91.0, 9.1900);

        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertStringContainsString('Latitudine non valida', $exception->getMessage());
    }
});

it('throws exception for invalid longitude below -180', function (): void {
    $action = new GetAddressFromMapboxLatLngAction();

    try {
        $action->execute(45.0, -181.0);

        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertStringContainsString('Longitudine non valida', $exception->getMessage());
    }
});

it('throws exception for invalid longitude above 180', function (): void {
    $action = new GetAddressFromMapboxLatLngAction();

    try {
        $action->execute(45.0, 181.0);

        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertStringContainsString('Longitudine non valida', $exception->getMessage());
    }
});

it('throws exception when api key is not configured', function (): void {
    $action = new GetAddressFromMapboxLatLngAction();

    config(['services.mapbox.api_key' => null]);

    try {
        $action->execute(45.4642, 9.1900);

        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('API key di Mapbox non configurata', $exception->getMessage());
    }
});

it('throws exception when api response is not successful', function (): void {
    $action = new GetAddressFromMapboxLatLngAction();

=======

function subject(): GetAddressFromMapboxLatLngAction
{
    return new GetAddressFromMapboxLatLngAction();
}

it('throws exception for invalid latitude below -90', function (): void {
    expect(fn () => subject()->execute(-91.0, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Latitudine non valida');
});

it('throws exception for invalid latitude above 90', function (): void {
    expect(fn () => subject()->execute(91.0, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Latitudine non valida');
});

it('throws exception for invalid longitude below -180', function (): void {
    expect(fn () => subject()->execute(45.0, -181.0))
        ->toThrow(InvalidLocationException::class, 'Longitudine non valida');
});

it('throws exception for invalid longitude above 180', function (): void {
    expect(fn () => subject()->execute(45.0, 181.0))
        ->toThrow(InvalidLocationException::class, 'Longitudine non valida');
});

it('throws exception when api key is not configured', function (): void {
    config(['services.mapbox.api_key' => null]);

    expect(fn () => subject()->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'API key di Mapbox non configurata');
});

it('throws exception when api response is not successful', function (): void {
>>>>>>> laraxot/dev
    config(['services.mapbox.api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response(['statusCode' => 500], 500),
    ]);

<<<<<<< HEAD
    try {
        $action->execute(45.4642, 9.1900);

        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Richiesta a Mapbox fallita', $exception->getMessage());
    }
});

it('throws exception when response is not valid json', function (): void {
    $action = new GetAddressFromMapboxLatLngAction();

=======
    expect(fn () => subject()->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Richiesta a Mapbox fallita');
});

it('throws exception when response is not valid json', function (): void {
>>>>>>> laraxot/dev
    config(['services.mapbox.api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response('not valid json', 200),
    ]);

<<<<<<< HEAD
    try {
        $action->execute(45.4642, 9.1900);

        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Risposta di Mapbox non valida', $exception->getMessage());
    }
});

it('throws exception when no features in response', function (): void {
    $action = new GetAddressFromMapboxLatLngAction();

=======
    expect(fn () => subject()->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Risposta di Mapbox non valida');
});

it('throws exception when no features in response', function (): void {
>>>>>>> laraxot/dev
    config(['services.mapbox.api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'features' => [],
        ], 200),
    ]);

<<<<<<< HEAD
    try {
        $action->execute(45.4642, 9.1900);

        Assert::fail('Expected InvalidLocationException was not thrown');
    } catch (InvalidLocationException $exception) {
        Assert::assertSame('Nessun risultato trovato', $exception->getMessage());
    }
});

it('returns address data for valid coordinates', function (): void {
    $action = new GetAddressFromMapboxLatLngAction();

=======
    expect(fn () => subject()->execute(45.4642, 9.1900))
        ->toThrow(InvalidLocationException::class, 'Nessun risultato trovato');
});

it('returns address data for valid coordinates', function (): void {
>>>>>>> laraxot/dev
    config(['services.mapbox.api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'features' => [[
                'center' => [9.1900, 45.4642],
                'text' => 'Via Roma',
                'address' => '1',
                'context' => [
                    ['id' => 'country.1', 'text' => 'Italia', 'short_code' => 'it'],
                    ['id' => 'place.1', 'text' => 'Milano'],
                    ['id' => 'postcode.1', 'text' => '20100'],
                    ['id' => 'region.1', 'text' => 'Lombardia'],
                    ['id' => 'neighborhood.1', 'text' => 'Centro'],
                ],
            ]],
        ], 200),
    ]);

<<<<<<< HEAD
    $result = $action->execute(45.4642, 9.1900);

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame(45.4642, $result->latitude);

    Assert::assertSame(9.1900, $result->longitude);

    Assert::assertSame('Italia', $result->country);

    Assert::assertSame('IT', $result->country_code);

    Assert::assertSame('Milano', $result->city);

    Assert::assertSame(20100, $result->postal_code);

    Assert::assertNull($result->locality);

    Assert::assertSame('Lombardia', $result->county);

    Assert::assertSame('Via Roma', $result->street);

    Assert::assertSame('1', $result->street_number);

    Assert::assertSame('Centro', $result->district);

    Assert::assertSame('Lombardia', $result->state);
});

it('handles boundary coordinate values', function (): void {
    $action = new GetAddressFromMapboxLatLngAction();

=======
    $result = subject()->execute(45.4642, 9.1900);

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900)
        ->and($result->country)->toBe('Italia')
        ->and($result->country_code)->toBe('IT')
        ->and($result->city)->toBe('Milano')
        ->and($result->postal_code)->toBe(20100)
        ->and($result->locality)->toBeNull()
        ->and($result->county)->toBe('Lombardia')
        ->and($result->street)->toBe('Via Roma')
        ->and($result->street_number)->toBe('1')
        ->and($result->district)->toBe('Centro')
        ->and($result->state)->toBe('Lombardia');
});

it('handles boundary coordinate values', function (): void {
>>>>>>> laraxot/dev
    config(['services.mapbox.api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'features' => [[
                'center' => [180.0, 90.0],
                'text' => 'North Pole',
                'context' => [
                    ['id' => 'country.1', 'text' => 'Unknown', 'short_code' => 'xx'],
                ],
            ]],
        ], 200),
    ]);

<<<<<<< HEAD
    $result = $action->execute(90.0, 180.0);

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame(90.0, $result->latitude);

    Assert::assertSame(180.0, $result->longitude);
});

it('handles missing context items', function (): void {
    $action = new GetAddressFromMapboxLatLngAction();

=======
    $result = subject()->execute(90.0, 180.0);

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->latitude)->toBe(90.0)
        ->and($result->longitude)->toBe(180.0);
});

it('handles missing context items', function (): void {
>>>>>>> laraxot/dev
    config(['services.mapbox.api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'features' => [[
                'center' => [9.1900, 45.4642],
                'text' => 'Via Roma',
            ]],
        ], 200),
    ]);

<<<<<<< HEAD
    $result = $action->execute(45.4642, 9.1900);

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertNull($result->country);

    Assert::assertNull($result->city);
=======
    $result = subject()->execute(45.4642, 9.1900);

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->country)->toBeNull()
        ->and($result->city)->toBeNull();
>>>>>>> laraxot/dev
});
