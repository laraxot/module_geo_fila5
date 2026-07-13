<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\LocationIQ;

<<<<<<< HEAD
use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\LocationIQ\GetAddressFromLocationIQAction;
use Modules\Geo\Datas\Geocoding\AddressData;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);
it('throws exception when api key is not configured', function (): void {
    $action = new GetAddressFromLocationIQAction();

    config(['services.locationiq.key' => null]);

    try {
        $action->execute('Milano, Italia');

        Assert::fail('Expected Exception was not thrown');
    } catch (\Exception $exception) {
        Assert::assertSame('LocationIQ API key not configured', $exception->getMessage());
    }
});

it('returns null when api response is not successful', function (): void {
    $action = new GetAddressFromLocationIQAction();

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

use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\LocationIQ\GetAddressFromLocationIQAction;
use Modules\Geo\Datas\AddressData;

function subject(): GetAddressFromLocationIQAction
{
    return new GetAddressFromLocationIQAction();
}

it('throws exception when api key is not configured', function (): void {
    config(['services.locationiq.key' => null]);

    expect(fn () => subject()->execute('Milano, Italia'))
        ->toThrow(Exception::class, 'LocationIQ API key not configured');
});

it('returns null when api response is not successful', function (): void {
>>>>>>> laraxot/dev
    config(['services.locationiq.key' => 'test_key']);

    Http::fake([
        '*' => Http::response(null, 500),
    ]);

<<<<<<< HEAD
    $result = $action->execute('Milano, Italia');

    Assert::assertNull($result);
});

it('returns null when no results found', function (): void {
    $action = new GetAddressFromLocationIQAction();

=======
    $result = subject()->execute('Milano, Italia');

    expect($result)->toBeNull();
});

it('returns null when no results found', function (): void {
>>>>>>> laraxot/dev
    config(['services.locationiq.key' => 'test_key']);

    Http::fake([
        '*' => Http::response([], 200),
    ]);

<<<<<<< HEAD
    $result = $action->execute('NonExistentPlace');

    Assert::assertNull($result);
});

it('returns null when first result is empty', function (): void {
    $action = new GetAddressFromLocationIQAction();

=======
    $result = subject()->execute('NonExistentPlace');

    expect($result)->toBeNull();
});

it('returns null when first result is empty', function (): void {
>>>>>>> laraxot/dev
    config(['services.locationiq.key' => 'test_key']);

    Http::fake([
        '*' => Http::response([[]], 200),
    ]);

<<<<<<< HEAD
    $result = $action->execute('NonExistentPlace');

    Assert::assertNull($result);
});

it('returns address data for valid response', function (): void {
    $action = new GetAddressFromLocationIQAction();

=======
    $result = subject()->execute('NonExistentPlace');

    expect($result)->toBeNull();
});

it('returns address data for valid response', function (): void {
>>>>>>> laraxot/dev
    config(['services.locationiq.key' => 'test_key']);

    Http::fake([
        '*' => Http::response([[
            'lat' => '45.4642',
            'lon' => '9.1900',
            'address' => [
                'country' => 'Italia',
                'city' => 'Milano',
                'town' => null,
                'village' => null,
                'country_code' => 'it',
                'postcode' => '20100',
                'suburb' => 'Centro',
                'county' => 'Milano',
                'road' => 'Via Roma',
                'house_number' => '1',
                'state' => 'Lombardia',
            ],
        ]], 200),
    ]);

<<<<<<< HEAD
    $result = $action->execute('Via Roma 1, Milano, Italia');

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame(45.4642, $result->latitude);

    Assert::assertSame(9.1900, $result->longitude);

    Assert::assertSame('Italia', $result->country);

    Assert::assertSame('Milano', $result->city);

    Assert::assertSame('it', $result->country_code);

    Assert::assertSame(20100, $result->postal_code);

    Assert::assertSame('Centro', $result->locality);

    Assert::assertSame('Milano', $result->county);

    Assert::assertSame('Via Roma', $result->street);

    Assert::assertSame('1', $result->street_number);

    Assert::assertSame('Centro', $result->district);

    Assert::assertSame('Lombardia', $result->state);
});

it('uses default country when missing', function (): void {
    $action = new GetAddressFromLocationIQAction();

=======
    $result = subject()->execute('Via Roma 1, Milano, Italia');

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900)
        ->and($result->country)->toBe('Italia')
        ->and($result->city)->toBe('Milano')
        ->and($result->country_code)->toBe('it')
        ->and($result->postal_code)->toBe(20100)
        ->and($result->locality)->toBe('Centro')
        ->and($result->county)->toBe('Milano')
        ->and($result->street)->toBe('Via Roma')
        ->and($result->street_number)->toBe('1')
        ->and($result->district)->toBe('Centro')
        ->and($result->state)->toBe('Lombardia');
});

it('uses default country when missing', function (): void {
>>>>>>> laraxot/dev
    config(['services.locationiq.key' => 'test_key']);

    Http::fake([
        '*' => Http::response([[
            'lat' => '45.4642',
            'lon' => '9.1900',
            'address' => [],
        ]], 200),
    ]);

<<<<<<< HEAD
    $result = $action->execute('Milano');

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame('Italia', $result->country);

    Assert::assertSame('IT', $result->country_code);
});

it('falls back to town and village for city', function (): void {
    $action = new GetAddressFromLocationIQAction();

=======
    $result = subject()->execute('Milano');

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->country)->toBe('Italia')
        ->and($result->country_code)->toBe('IT');
});

it('falls back to town and village for city', function (): void {
>>>>>>> laraxot/dev
    config(['services.locationiq.key' => 'test_key']);

    Http::fake([
        '*' => Http::response([[
            'lat' => '45.4642',
            'lon' => '9.1900',
            'address' => [
                'country' => 'Italia',
                'town' => 'Cinisello Balsamo',
                'country_code' => 'it',
            ],
        ]], 200),
    ]);

<<<<<<< HEAD
    $result = $action->execute('Cinisello Balsamo');

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame('Cinisello Balsamo', $result->city);
=======
    $result = subject()->execute('Cinisello Balsamo');

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->city)->toBe('Cinisello Balsamo');
>>>>>>> laraxot/dev
});
