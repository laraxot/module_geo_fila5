<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GoogleMaps;

<<<<<<< HEAD
=======
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);
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
use Modules\Geo\Actions\GoogleMaps\GetAddressFromGoogleMapsAction;
use Modules\Geo\Datas\Geocoding\AddressData;
use Modules\Geo\Exceptions\GoogleMaps\GoogleMapsApiException;
<<<<<<< HEAD
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);
it('throws exception when api key is not configured', function (): void {
    $action = new GetAddressFromGoogleMapsAction();

    config(['services.google.maps_api_key' => null]);

    try {
        $action->execute('Milano, Italia');

        Assert::fail('Expected GoogleMapsApiException was not thrown');
    } catch (GoogleMapsApiException $exception) {
        Assert::assertSame('API key non configurata', $exception->getMessage());
    }
});

it('throws exception when api key is empty', function (): void {
    $action = new GetAddressFromGoogleMapsAction();

    config(['services.google.maps_api_key' => '']);

    try {
        $action->execute('Milano, Italia');

        Assert::fail('Expected GoogleMapsApiException was not thrown');
    } catch (GoogleMapsApiException) {
    }
});

it('throws exception when api response is not successful', function (): void {
    $action = new GetAddressFromGoogleMapsAction();

=======

function subject(): GetAddressFromGoogleMapsAction
{
    return new GetAddressFromGoogleMapsAction();
}

it('throws exception when api key is not configured', function (): void {
    config(['services.google.maps_api_key' => null]);

    expect(fn () => subject()->execute('Milano, Italia'))
        ->toThrow(GoogleMapsApiException::class, 'API key di Google Maps non configurata');
});

it('throws exception when api key is empty', function (): void {
    config(['services.google.maps_api_key' => '']);

    expect(fn () => subject()->execute('Milano, Italia'))
        ->toThrow(GoogleMapsApiException::class);
});

it('throws exception when api response is not successful', function (): void {
>>>>>>> laraxot/dev
    config(['services.google.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response(['statusCode' => 500], 500),
    ]);

<<<<<<< HEAD
    try {
        $action->execute('Milano, Italia');

        Assert::fail('Expected GoogleMapsApiException was not thrown');
    } catch (GoogleMapsApiException $exception) {
        Assert::assertSame('Richiesta fallita', $exception->getMessage());
    }
});

it('throws exception when no results found', function (): void {
    $action = new GetAddressFromGoogleMapsAction();

=======
    expect(fn () => subject()->execute('Milano, Italia'))
        ->toThrow(GoogleMapsApiException::class, '500');
});

it('throws exception when no results found', function (): void {
>>>>>>> laraxot/dev
    config(['services.google.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
<<<<<<< HEAD
=======
            'status' => 'ZERO_RESULTS',
>>>>>>> laraxot/dev
            'results' => [],
        ], 200),
    ]);

<<<<<<< HEAD
    try {
        $action->execute('NonExistentPlace123');

        Assert::fail('Expected GoogleMapsApiException was not thrown');
    } catch (GoogleMapsApiException $exception) {
        Assert::assertSame('Nessun risultato', $exception->getMessage());
    }
});

it('returns address data for valid address', function (): void {
    $action = new GetAddressFromGoogleMapsAction();

=======
    expect(fn () => subject()->execute('NonExistentPlace123'))
        ->toThrow(GoogleMapsApiException::class, 'Nessun risultato trovato');
});

it('returns address data for valid address', function (): void {
>>>>>>> laraxot/dev
    config(['services.google.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
<<<<<<< HEAD
            'results' => [[
=======
            'status' => 'OK',
            'results' => [[
                'formatted_address' => 'Via Roma 1, 20100 Milano MI, Italia',
                'types' => ['street_address'],
>>>>>>> laraxot/dev
                'geometry' => [
                    'location' => [
                        'lat' => 45.4642,
                        'lng' => 9.1900,
                    ],
                ],
                'address_components' => [
                    ['long_name' => 'Italia', 'short_name' => 'IT', 'types' => ['country']],
                    ['long_name' => 'Milano', 'short_name' => 'MI', 'types' => ['administrative_area_level_3']],
                    ['long_name' => 'Milano', 'short_name' => 'MI', 'types' => ['locality']],
                    ['long_name' => 'Lombardia', 'short_name' => 'Lombardia', 'types' => ['administrative_area_level_1']],
                    ['long_name' => '20100', 'short_name' => '20100', 'types' => ['postal_code']],
                    ['long_name' => 'Via Roma', 'short_name' => 'Via Roma', 'types' => ['route']],
                    ['long_name' => '1', 'short_name' => '1', 'types' => ['street_number']],
                    ['long_name' => 'Centro', 'short_name' => 'Centro', 'types' => ['sublocality_level_1']],
                    ['long_name' => 'Milano', 'short_name' => 'MI', 'types' => ['administrative_area_level_2']],
                ],
            ]],
        ], 200),
    ]);

<<<<<<< HEAD
    $result = $action->execute('Via Roma 1, Milano, Italia');

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame(45.4642, $result->latitude);

    Assert::assertSame(9.1900, $result->longitude);

    Assert::assertSame('Italia', $result->country);

    Assert::assertSame('IT', $result->country_code);

    Assert::assertSame(20100, $result->postal_code);

    Assert::assertSame('Milano', $result->locality);

    Assert::assertSame('Via Roma', $result->street);

    Assert::assertSame('1', $result->street_number);

    Assert::assertSame('Centro', $result->district);

    Assert::assertSame('Milano', $result->county);

    Assert::assertSame('Lombardia', $result->state);
});

it('handles missing optional address components', function (): void {
    $action = new GetAddressFromGoogleMapsAction();

=======
    $result = subject()->execute('Via Roma 1, Milano, Italia');

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900)
        ->and($result->country)->toBe('Italia')
        ->and($result->country_code)->toBe('IT')
        ->and($result->postal_code)->toBe(20100)
        ->and($result->locality)->toBe('Milano')
        ->and($result->street)->toBe('Via Roma')
        ->and($result->street_number)->toBe('1')
        ->and($result->district)->toBe('Centro')
        ->and($result->county)->toBe('Milano')
        ->and($result->state)->toBe('Lombardia');
});

it('handles missing optional address components', function (): void {
>>>>>>> laraxot/dev
    config(['services.google.maps_api_key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
<<<<<<< HEAD
            'results' => [[
=======
            'status' => 'OK',
            'results' => [[
                'formatted_address' => 'Via Roma 1, 20100 Milano MI, Italia',
                'types' => ['street_address'],
>>>>>>> laraxot/dev
                'geometry' => [
                    'location' => [
                        'lat' => 45.4642,
                        'lng' => 9.1900,
                    ],
                ],
                'address_components' => [
                    ['long_name' => 'Italia', 'short_name' => 'IT', 'types' => ['country']],
                ],
            ]],
        ], 200),
    ]);

<<<<<<< HEAD
    $result = $action->execute('Italia');

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame(45.4642, $result->latitude);

    Assert::assertSame(9.1900, $result->longitude);

    Assert::assertSame('Italia', $result->country);

    Assert::assertSame('', $result->street);
=======
    $result = subject()->execute('Italia');

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900)
        ->and($result->country)->toBe('Italia')
        ->and($result->street)->toBe('');
>>>>>>> laraxot/dev
});
