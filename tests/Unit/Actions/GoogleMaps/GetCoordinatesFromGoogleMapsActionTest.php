<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\GoogleMaps;

use GuzzleHttp\Client;
<<<<<<< Updated upstream
use GuzzleHttp\Exception\RequestException;
=======
<<<<<<< HEAD
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);
>>>>>>> Stashed changes
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\GoogleMaps\GetCoordinatesFromGoogleMapsAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

beforeEach(function () {
    $this->mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($this->mockHandler);
    $client = new Client(['handler' => $handlerStack]);
<<<<<<< Updated upstream
    $this->action = new GetCoordinatesFromGoogleMapsAction($client);
=======
    $action = new GetCoordinatesFromGoogleMapsAction($this->client);
=======
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\GoogleMaps\GetCoordinatesFromGoogleMapsAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

beforeEach(function () {
    $this->mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($this->mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $this->action = new GetCoordinatesFromGoogleMapsAction($client);
>>>>>>> origin/dev
>>>>>>> Stashed changes
});

it('throws exception when api key is not configured', function (): void {
    config(['services.google.maps_api_key' => null]);

<<<<<<< Updated upstream
    expect(fn () => $this->action->execute('Milano, Italia'))
        ->toThrow(InvalidArgumentException::class, 'Google Maps API key not configured');
=======
<<<<<<< HEAD
    expect(fn () => $action->execute('Milano, Italia'))
        ->toThrow(RuntimeException::class, 'Google Maps API key not configured');
=======
    expect(fn () => $this->action->execute('Milano, Italia'))
        ->toThrow(InvalidArgumentException::class, 'Google Maps API key not configured');
>>>>>>> origin/dev
>>>>>>> Stashed changes
});

it('throws exception for empty address', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

<<<<<<< Updated upstream
    expect(fn () => $this->action->execute(''))
=======
<<<<<<< HEAD
    expect(fn () => $action->execute(''))
=======
    expect(fn () => $this->action->execute(''))
>>>>>>> origin/dev
>>>>>>> Stashed changes
        ->toThrow(InvalidArgumentException::class, 'Address cannot be empty');
});

it('throws exception for too long address', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

    $longAddress = str_repeat('a', 1001);

<<<<<<< Updated upstream
    expect(fn () => $this->action->execute($longAddress))
=======
<<<<<<< HEAD
    expect(fn () => $action->execute($longAddress))
=======
    expect(fn () => $this->action->execute($longAddress))
>>>>>>> origin/dev
>>>>>>> Stashed changes
        ->toThrow(InvalidArgumentException::class, 'Address is too long');
});

it('throws exception for guzzle exception', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

<<<<<<< Updated upstream
    $this->mockHandler->append(new RequestException('Error', new Request('GET', 'http://test')));

    expect(fn () => $this->action->execute('Milano, Italia'))
        ->toThrow(RuntimeException::class, 'Failed to get coordinates from address');
=======
<<<<<<< HEAD
    $mockHandler->append(new GuzzleHttp\Exception\RequestException('Error', new GuzzleHttp\Psr7\Request('GET', 'http://test')));

    expect(fn () => $action->execute('Milano, Italia'))
        ->toThrow(RuntimeException::class, 'Failed to get coordinates');
=======
    $this->mockHandler->append(new RequestException('Error', new Request('GET', 'http://test')));

    expect(fn () => $this->action->execute('Milano, Italia'))
        ->toThrow(RuntimeException::class, 'Failed to get coordinates from address');
>>>>>>> origin/dev
>>>>>>> Stashed changes
});

it('throws exception when no coordinates found', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

<<<<<<< Updated upstream
    $this->mockHandler->append(new Response(200, [], json_encode([
=======
<<<<<<< HEAD
    $mockHandler->append(new Response(200, [], json_encode([)))
=======
    $this->mockHandler->append(new Response(200, [], json_encode([
>>>>>>> origin/dev
>>>>>>> Stashed changes
        'status' => 'OK',
        'results' => [],
    ])));

<<<<<<< Updated upstream
    expect(fn () => $this->action->execute('NonExistentPlace'))
        ->toThrow(RuntimeException::class, 'No coordinates found for address');
=======
<<<<<<< HEAD
    expect(fn () => $action->execute('NonExistentPlace'))
        ->toThrow(RuntimeException::class, 'No coordinates found');
=======
    expect(fn () => $this->action->execute('NonExistentPlace'))
        ->toThrow(RuntimeException::class, 'No coordinates found for address');
>>>>>>> origin/dev
>>>>>>> Stashed changes
});

it('throws exception when status is not OK', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

<<<<<<< Updated upstream
    $this->mockHandler->append(new Response(200, [], json_encode([
        'status' => 'ZERO_RESULTS',
    ])));

    expect(fn () => $this->action->execute('NonExistentPlace'))
        ->toThrow(RuntimeException::class, 'No coordinates found for address');
=======
<<<<<<< HEAD
    $mockHandler->append(new Response(200, [], json_encode([)))
        'status' => 'ZERO_RESULTS',
    ])));

    expect(fn () => $action->execute('NonExistentPlace'))
        ->toThrow(RuntimeException::class, 'No coordinates found');
=======
    $this->mockHandler->append(new Response(200, [], json_encode([
        'status' => 'ZERO_RESULTS',
    ])));

    expect(fn () => $this->action->execute('NonExistentPlace'))
        ->toThrow(RuntimeException::class, 'No coordinates found for address');
>>>>>>> origin/dev
>>>>>>> Stashed changes
});

it('returns location data for valid address', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

<<<<<<< Updated upstream
    $this->mockHandler->append(new Response(200, [], json_encode([
=======
<<<<<<< HEAD
    $mockHandler->append(new Response(200, [], json_encode([)))
=======
    $this->mockHandler->append(new Response(200, [], json_encode([
>>>>>>> origin/dev
>>>>>>> Stashed changes
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

<<<<<<< Updated upstream
    $result = $this->action->execute('Milano, Italia');
=======
<<<<<<< HEAD
    $result = $action->execute('Milano, Italia');
=======
    $result = $this->action->execute('Milano, Italia');
>>>>>>> origin/dev
>>>>>>> Stashed changes

    expect($result)
        ->toBeInstanceOf(LocationData::class)
        ->and($result->address)->toBe('Milano, Italia')
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900);
});

it('handles address with special characters', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

<<<<<<< Updated upstream
    $this->mockHandler->append(new Response(200, [], json_encode([
=======
<<<<<<< HEAD
    $mockHandler->append(new Response(200, [], json_encode([)))
=======
    $this->mockHandler->append(new Response(200, [], json_encode([
>>>>>>> origin/dev
>>>>>>> Stashed changes
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

<<<<<<< Updated upstream
    $result = $this->action->execute('Piazza del Popolo, Roma, Italia');
=======
<<<<<<< HEAD
    $result = $action->execute('Piazza del Popolo, Roma, Italia');
=======
    $result = $this->action->execute('Piazza del Popolo, Roma, Italia');
>>>>>>> origin/dev
>>>>>>> Stashed changes

    expect($result)
        ->toBeInstanceOf(LocationData::class)
        ->and($result->latitude)->toBe(41.9028)
        ->and($result->longitude)->toBe(12.4964);
});
