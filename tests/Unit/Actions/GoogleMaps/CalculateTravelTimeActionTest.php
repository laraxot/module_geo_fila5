<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GoogleMaps;

use GuzzleHttp\Client;
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
// Laraxot module file — see docs/wiki for domain contract.
>>>>>>> laraxot/dev
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\GoogleMaps\CalculateTravelTimeAction;
use Modules\Geo\Datas\LocationData;
<<<<<<< HEAD
use Modules\Geo\Datas\Routing\TravelTimeData;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(LightTestCase::class);

it('throws exception when api key is not configured', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new CalculateTravelTimeAction($client);

=======
use Modules\Geo\Datas\TravelTimeData;

beforeEach(function () {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new CalculateTravelTimeAction($this->client);
});

it('throws exception when api key is not configured', function (): void {
>>>>>>> laraxot/dev
    config(['services.google.maps_api_key' => null]);

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

<<<<<<< HEAD
    try {
        $action->execute($origin, $destination);

        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Google Maps API key not configured', $exception->getMessage());
    }
});

it('throws exception when origin and destination are the same', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new CalculateTravelTimeAction($client);

=======
    expect(fn () => $action->execute($origin, $destination))
        ->toThrow(RuntimeException::class, 'Google Maps API key not configured');
});

it('throws exception when origin and destination are the same', function (): void {
>>>>>>> laraxot/dev
    config(['services.google.maps_api_key' => 'test_key']);

    $location = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');

<<<<<<< HEAD
    expect(fn (): TravelTimeData => $action->execute($location, $location))
        ->toThrow(\InvalidArgumentException::class);
});

it('returns error travel time data for failed api request', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new CalculateTravelTimeAction($client);

=======
    expect(fn () => $action->execute($location, $location))
        ->toThrow(InvalidArgumentException::class, 'Origin and destination cannot be the same');
});

it('returns error travel time data for failed api request', function (): void {
>>>>>>> laraxot/dev
    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(500, [], 'Server Error'));

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $action->execute($origin, $destination);

<<<<<<< HEAD
    Assert::assertInstanceOf(TravelTimeData::class, $result);

    Assert::assertSame('REQUEST_FAILED', $result->status);
});

it('returns error for invalid response status', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new CalculateTravelTimeAction($client);

=======
    expect($result)
        ->toBeInstanceOf(TravelTimeData::class)
        ->and($result->status)->toBe('REQUEST_FAILED');
});

it('returns error for invalid response status', function (): void {
>>>>>>> laraxot/dev
    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'INVALID_REQUEST',
    ])));

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $action->execute($origin, $destination);

<<<<<<< HEAD
    Assert::assertInstanceOf(TravelTimeData::class, $result);

    Assert::assertSame('INVALID_RESPONSE', $result->status);
});

it('returns error when no route found', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new CalculateTravelTimeAction($client);

=======
    expect($result)
        ->toBeInstanceOf(TravelTimeData::class)
        ->and($result->status)->toBe('INVALID_RESPONSE');
});

it('returns error when no route found', function (): void {
>>>>>>> laraxot/dev
    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'rows' => [[
            'elements' => [[
                'status' => 'ZERO_RESULTS',
            ]],
        ]],
    ])));

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $action->execute($origin, $destination);

<<<<<<< HEAD
    Assert::assertInstanceOf(TravelTimeData::class, $result);

    Assert::assertSame('NO_ROUTE', $result->status);
});

it('returns travel time data for valid route', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new CalculateTravelTimeAction($client);

=======
    expect($result)
        ->toBeInstanceOf(TravelTimeData::class)
        ->and($result->status)->toBe('NO_ROUTE');
});

it('returns travel time data for valid route', function (): void {
>>>>>>> laraxot/dev
    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'rows' => [[
            'elements' => [[
                'duration' => ['value' => 19800, 'text' => '5 hours 30 mins'],
                'duration_in_traffic' => ['value' => 21000, 'text' => '5 hours 50 mins'],
                'distance' => ['value' => 572000, 'text' => '572 km'],
            ]],
        ]],
    ])));

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $action->execute($origin, $destination);

<<<<<<< HEAD
    Assert::assertInstanceOf(TravelTimeData::class, $result);

    Assert::assertSame(19800, $result->duration_seconds);

    Assert::assertSame(21000, $result->duration_in_traffic_seconds);

    Assert::assertSame(572000, $result->distance_meters);

    Assert::assertSame('5 hours 30 mins', $result->formatted_duration);

    Assert::assertSame('572 km', $result->formatted_distance);

    Assert::assertSame('OK', $result->status);
});

it('uses duration as fallback for duration in traffic', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new CalculateTravelTimeAction($client);

=======
    expect($result)
        ->toBeInstanceOf(TravelTimeData::class)
        ->and($result->duration_seconds)->toBe(19800)
        ->and($result->duration_in_traffic_seconds)->toBe(21000)
        ->and($result->distance_meters)->toBe(572000)
        ->and($result->formatted_duration)->toBe('5 hours 30 mins')
        ->and($result->formatted_distance)->toBe('572 km')
        ->and($result->status)->toBe('OK');
});

it('uses duration as fallback for duration in traffic', function (): void {
>>>>>>> laraxot/dev
    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'OK',
        'rows' => [[
            'elements' => [[
                'duration' => ['value' => 19800, 'text' => '5 hours 30 mins'],
                'distance' => ['value' => 572000, 'text' => '572 km'],
            ]],
        ]],
    ])));

    $origin = new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano');
    $destination = new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma');

    $result = $action->execute($origin, $destination);

<<<<<<< HEAD
    Assert::assertInstanceOf(TravelTimeData::class, $result);

    Assert::assertSame(19800, $result->duration_in_traffic_seconds);
=======
    expect($result)
        ->toBeInstanceOf(TravelTimeData::class)
        ->and($result->duration_in_traffic_seconds)->toBe(19800);
>>>>>>> laraxot/dev
});
