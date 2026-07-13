<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GoogleMaps;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\GoogleMaps\GetCoordinatesFromGoogleMapsAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Tests\LightTestCase;
<<<<<<< HEAD
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(LightTestCase::class);
it('throws exception when api key is not configured', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => null]);

    try {
        $action->execute('Milano, Italia');

        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Google Maps API key not configured', $exception->getMessage());
    }
});

it('throws exception for empty address', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    expect(fn (): LocationData => $action->execute(''))
        ->toThrow(\InvalidArgumentException::class, 'Address cannot be empty');
});

it('throws exception for too long address', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($client);

=======

uses(LightTestCase::class);
// Laraxot — see module docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
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
    $this->action = new GetCoordinatesFromGoogleMapsAction($client);
});

it('throws exception when api key is not configured', function (): void {
    config(['services.google.maps_api_key' => null]);

    expect(fn () => $this->action->execute('Milano, Italia'))
        ->toThrow(InvalidArgumentException::class, 'Google Maps API key not configured');
});

it('throws exception for empty address', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    expect(fn () => $this->action->execute(''))
        ->toThrow(InvalidArgumentException::class, 'Address cannot be empty');
});

it('throws exception for too long address', function (): void {
>>>>>>> laraxot/dev
    config(['services.google.maps_api_key' => 'test_key']);

    $longAddress = str_repeat('a', 1001);

<<<<<<< HEAD
    expect(fn (): LocationData => $action->execute($longAddress))
        ->toThrow(\InvalidArgumentException::class, 'Address is too long');
});

it('throws exception for guzzle exception', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new RequestException('Error', new Request('GET', 'http://test')));

    try {
        $action->execute('Milano, Italia');

        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Failed to get coordinates from address', $exception->getMessage());
    }
});

it('throws exception when no coordinates found', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
=======
    expect(fn () => $this->action->execute($longAddress))
        ->toThrow(InvalidArgumentException::class, 'Address is too long');
});

it('throws exception for guzzle exception', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $this->mockHandler->append(new RequestException('Error', new Request('GET', 'http://test')));

    expect(fn () => $this->action->execute('Milano, Italia'))
        ->toThrow(RuntimeException::class, 'Failed to get coordinates from address');
});

it('throws exception when no coordinates found', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
>>>>>>> laraxot/dev
        'status' => 'OK',
        'results' => [],
    ])));

<<<<<<< HEAD
    try {
        $action->execute('NonExistentPlace');

        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('No coordinates found for address', $exception->getMessage());
    }
});

it('throws exception when status is not OK', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'status' => 'ZERO_RESULTS',
    ])));

    try {
        $action->execute('NonExistentPlace');

        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('No coordinates found for address', $exception->getMessage());
    }
});

it('returns location data for valid address', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
=======
    expect(fn () => $this->action->execute('NonExistentPlace'))
        ->toThrow(RuntimeException::class, 'No coordinates found for address');
});

it('throws exception when status is not OK', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
        'status' => 'ZERO_RESULTS',
    ])));

    expect(fn () => $this->action->execute('NonExistentPlace'))
        ->toThrow(RuntimeException::class, 'No coordinates found for address');
});

it('returns location data for valid address', function (): void {
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
        ]],
    ])));

<<<<<<< HEAD
    $result = $action->execute('Milano, Italia');

    Assert::assertInstanceOf(LocationData::class, $result);

    Assert::assertSame('Milano, Italia', $result->address);

    Assert::assertSame(45.4642, $result->latitude);

    Assert::assertSame(9.1900, $result->longitude);
});

it('handles address with special characters', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetCoordinatesFromGoogleMapsAction($client);

    config(['services.google.maps_api_key' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
=======
    $result = $this->action->execute('Milano, Italia');

    expect($result)
        ->toBeInstanceOf(LocationData::class)
        ->and($result->address)->toBe('Milano, Italia')
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900);
});

it('handles address with special characters', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
>>>>>>> laraxot/dev
        'status' => 'OK',
        'results' => [[
            'geometry' => [
                'location' => [
                    'lat' => 41.9028,
                    'lng' => 12.4964,
                ],
            ],
        ]],
    ])));

<<<<<<< HEAD
    $result = $action->execute('Piazza del Popolo, Roma, Italia');

    Assert::assertInstanceOf(LocationData::class, $result);

    Assert::assertSame(41.9028, $result->latitude);

    Assert::assertSame(12.4964, $result->longitude);
=======
    $result = $this->action->execute('Piazza del Popolo, Roma, Italia');

    expect($result)
        ->toBeInstanceOf(LocationData::class)
        ->and($result->latitude)->toBe(41.9028)
        ->and($result->longitude)->toBe(12.4964);
>>>>>>> laraxot/dev
});
