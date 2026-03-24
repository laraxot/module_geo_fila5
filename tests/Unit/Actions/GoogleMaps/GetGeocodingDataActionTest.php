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
use Modules\Geo\Actions\GoogleMaps\GetGeocodingDataAction;
use Modules\Geo\Datas\GeocodingData;
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

beforeEach(function () {
    $this->mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($this->mockHandler);
    $client = new Client(['handler' => $handlerStack]);
<<<<<<< Updated upstream
    $this->action = new GetGeocodingDataAction($client);
=======
    $action = new GetGeocodingDataAction($this->client);
=======
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\GoogleMaps\GetGeocodingDataAction;
use Modules\Geo\Datas\GeocodingData;
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

beforeEach(function () {
    $this->mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($this->mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $this->action = new GetGeocodingDataAction($client);
>>>>>>> origin/dev
>>>>>>> Stashed changes
});

it('throws exception when api key is not configured', function (): void {
    config(['services.google.maps_api_key' => null]);

<<<<<<< Updated upstream
    expect(fn () => $this->action->execute('Milano, Italia'))
=======
<<<<<<< HEAD
    expect(fn () => $action->execute('Milano, Italia'))
=======
    expect(fn () => $this->action->execute('Milano, Italia'))
>>>>>>> origin/dev
>>>>>>> Stashed changes
        ->toThrow(RuntimeException::class, 'Chiave API Google Maps non configurata');
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
        ->toThrow(RuntimeException::class, 'Indirizzo non può essere vuoto');
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
        ->toThrow(RuntimeException::class, 'Indirizzo troppo lungo');
});

it('returns error geocoding data for guzzle exception', function (): void {
    config(['services.google.maps_api_key' => 'test_key']);

<<<<<<< Updated upstream
    $this->mockHandler->append(new RequestException('Error', new Request('GET', 'http://test')));

    $result = $this->action->execute('Milano, Italia');
=======
<<<<<<< HEAD
    $mockHandler->append(new GuzzleHttp\Exception\RequestException('Error', new GuzzleHttp\Psr7\Request('GET', 'http://test')));

    $result = $action->execute('Milano, Italia');
=======
    $this->mockHandler->append(new RequestException('Error', new Request('GET', 'http://test')));

    $result = $this->action->execute('Milano, Italia');
>>>>>>> origin/dev
>>>>>>> Stashed changes

    expect($result)
        ->toBeInstanceOf(GeocodingData::class)
        ->and($result->isError())->toBeTrue()
        ->and($result->status)->toBe('REQUEST_FAILED');
});

it('returns error geocoding data for invalid status', function (): void {
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
        'status' => 'ZERO_RESULTS',
        'results' => [],
    ])));

<<<<<<< Updated upstream
    $result = $this->action->execute('NonExistentPlace');

    expect($result)
        ->toBeInstanceOf(GeocodingData::class)
        ->and($result->isError())->toBeTrue()
        ->and($result->status)->toBe('ZERO_RESULTS');
=======
<<<<<<< HEAD
    $result = $action->execute('NonExistentPlace');

    expect($result)
        ->toBeInstanceOf(GeocodingData::class)
        ->and($result->isError())->toBeTrue();
=======
    $result = $this->action->execute('NonExistentPlace');

    expect($result)
        ->toBeInstanceOf(GeocodingData::class)
        ->and($result->isError())->toBeTrue()
        ->and($result->status)->toBe('ZERO_RESULTS');
>>>>>>> origin/dev
>>>>>>> Stashed changes
});

it('returns geocoding data for valid address', function (): void {
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
            'formatted_address' => 'Via Roma, Milano, MI, Italia',
            'address_components' => [
                ['long_name' => 'Italia', 'short_name' => 'IT', 'types' => ['country']],
                ['long_name' => 'Milano', 'short_name' => 'MI', 'types' => ['locality']],
            ],
        ]],
    ])));

<<<<<<< Updated upstream
    $result = $this->action->execute('Via Roma, Milano, Italia');
=======
<<<<<<< HEAD
    $result = $action->execute('Via Roma, Milano, Italia');
=======
    $result = $this->action->execute('Via Roma, Milano, Italia');
>>>>>>> origin/dev
>>>>>>> Stashed changes

    expect($result)
        ->toBeInstanceOf(GeocodingData::class)
        ->and($result->isError())->toBeFalse()
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900);
});
