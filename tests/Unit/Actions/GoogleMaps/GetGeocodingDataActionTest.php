<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GoogleMaps;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\GoogleMaps\GetGeocodingDataAction;
<<<<<<< HEAD
use Modules\Geo\Datas\Geocoding\GeocodingData;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(LightTestCase::class);
it('throws exception when api key is not configured', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetGeocodingDataAction($client);

    config(['services.google.maps_api_key' => null]);

    try {
        $action->execute('Milano, Italia');
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Chiave API Google Maps non configurata', $exception->getMessage());
    }
});

it('throws exception for empty address', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetGeocodingDataAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    try {
        $action->execute('');
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Indirizzo non può essere vuoto', $exception->getMessage());
    }
});

it('throws exception for too long address', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetGeocodingDataAction($client);

=======
use Modules\Geo\Datas\GeocodingData;
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);
// Laraxot — see module docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.

beforeEach(function () {
    $this->mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($this->mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $this->action = new GetGeocodingDataAction($client);
});

it('throws exception when api key is not configured', function (): void {
    config(['services.google.maps_api_key' => null]);

    expect(fn () => $this->action->execute('Milano, Italia'))
        ->toThrow(RuntimeException::class, 'Chiave API Google Maps non configurata');
});

it('throws exception for empty address', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    expect(fn () => $this->action->execute(''))
        ->toThrow(RuntimeException::class, 'Indirizzo non può essere vuoto');
});

it('throws exception for too long address', function (): void {
>>>>>>> laraxot/dev
    config(['services.google.maps_api_key' => 'test_key']);

    $longAddress = str_repeat('a', 1001);

<<<<<<< HEAD
    try {
        $action->execute($longAddress);
        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Indirizzo troppo lungo', $exception->getMessage());
    }
});

it('returns error geocoding data for guzzle exception', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetGeocodingDataAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new RequestException('Error', new Request('GET', 'http://test')));

    $result = $action->execute('Milano, Italia');

    Assert::assertInstanceOf(GeocodingData::class, $result);
    Assert::assertNotNull($result->error);
    Assert::assertSame('REQUEST_FAILED', $result->error);
});

it('returns error geocoding data for invalid status', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetGeocodingDataAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
=======
    expect(fn () => $this->action->execute($longAddress))
        ->toThrow(RuntimeException::class, 'Indirizzo troppo lungo');
});

it('returns error geocoding data for guzzle exception', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $this->mockHandler->append(new RequestException('Error', new Request('GET', 'http://test')));

    $result = $this->action->execute('Milano, Italia');

    expect($result)
        ->toBeInstanceOf(GeocodingData::class)
        ->and($result->isError())->toBeTrue()
        ->and($result->status)->toBe('REQUEST_FAILED');
});

it('returns error geocoding data for invalid status', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
>>>>>>> laraxot/dev
        'status' => 'ZERO_RESULTS',
        'results' => [],
    ])));

<<<<<<< HEAD
    $result = $action->execute('NonExistentPlace');

    Assert::assertInstanceOf(GeocodingData::class, $result);
    Assert::assertNotNull($result->error);
    Assert::assertSame('ZERO_RESULTS', $result->error);
});

it('returns geocoding data for valid address', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetGeocodingDataAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
=======
    $result = $this->action->execute('NonExistentPlace');

    expect($result)
        ->toBeInstanceOf(GeocodingData::class)
        ->and($result->isError())->toBeTrue()
        ->and($result->status)->toBe('ZERO_RESULTS');
});

it('returns geocoding data for valid address', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
>>>>>>> laraxot/dev
        'status' => 'OK',
        'results' => [[
            'geometry' => [
                'location' => [
                    'lat' => 45.4642,
                    'lng' => 9.1900,
                ],
            ],
            'formatted_address' => 'Via Roma, Milano, MI, Italia',
            'address_components' => [
                ['long_name' => 'Italia', 'short_name' => 'IT', 'types' => ['country']],
                ['long_name' => 'Milano', 'short_name' => 'MI', 'types' => ['locality']],
            ],
        ]],
    ])));

<<<<<<< HEAD
    $result = $action->execute('Via Roma, Milano, Italia');

    Assert::assertInstanceOf(GeocodingData::class, $result);
    Assert::assertNull($result->error);
    Assert::assertSame(45.4642, $result->latitude);
    Assert::assertSame(9.1900, $result->longitude);
=======
    $result = $this->action->execute('Via Roma, Milano, Italia');

    expect($result)
        ->toBeInstanceOf(GeocodingData::class)
        ->and($result->isError())->toBeFalse()
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900);
>>>>>>> laraxot/dev
});
