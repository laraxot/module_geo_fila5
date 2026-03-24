<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\IPGeolocation;

<<<<<<< Updated upstream
=======
<<<<<<< HEAD
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

=======
>>>>>>> origin/dev
>>>>>>> Stashed changes
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\IPGeolocation\FetchIPLocationAction;
use Modules\Geo\Datas\IPLocationData;
<<<<<<< Updated upstream
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);
=======
<<<<<<< HEAD
>>>>>>> Stashed changes

beforeEach(function () {
    $this->mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($this->mockHandler);
    $client = new Client(['handler' => $handlerStack]);

    $this->action = new FetchIPLocationAction();

    $reflection = new ReflectionClass($this->action);
    $property = $reflection->getProperty('client');
    $property->setAccessible(true);
    $property->setValue($this->action, $client);
});

it('throws exception when ip-api returns failure status', function (): void {
<<<<<<< Updated upstream
    $this->mockHandler->append(new Response(200, [], json_encode([
=======
    $mockHandler->append(new Response(200, [], json_encode([)))
=======
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

beforeEach(function () {
    $this->mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($this->mockHandler);
    $client = new Client(['handler' => $handlerStack]);

    $this->action = new FetchIPLocationAction();

    $reflection = new ReflectionClass($this->action);
    $property = $reflection->getProperty('client');
    $property->setAccessible(true);
    $property->setValue($this->action, $client);
});

it('throws exception when ip-api returns failure status', function (): void {
    $this->mockHandler->append(new Response(200, [], json_encode([
>>>>>>> origin/dev
>>>>>>> Stashed changes
        'status' => 'fail',
        'message' => 'invalid query',
    ])));

<<<<<<< Updated upstream
    expect(fn () => $this->action->execute('8.8.8.8'))
=======
<<<<<<< HEAD
    expect(fn () => $action->execute('8.8.8.8'))
=======
    expect(fn () => $this->action->execute('8.8.8.8'))
>>>>>>> origin/dev
>>>>>>> Stashed changes
        ->toThrow(RuntimeException::class, 'Failed to get IP location: invalid query');
});

it('returns ip location data for valid response', function (): void {
<<<<<<< Updated upstream
    $this->mockHandler->append(new Response(200, [], json_encode([
=======
<<<<<<< HEAD
    $mockHandler->append(new Response(200, [], json_encode([)))
=======
    $this->mockHandler->append(new Response(200, [], json_encode([
>>>>>>> origin/dev
>>>>>>> Stashed changes
        'status' => 'success',
        'country' => 'United States',
        'countryCode' => 'US',
        'region' => 'VA',
        'regionName' => 'Virginia',
        'city' => 'Ashburn',
        'lat' => 39.03,
        'lon' => -77.5,
        'timezone' => 'America/New_York',
        'isp' => 'Google LLC',
    ])));

<<<<<<< Updated upstream
    $result = $this->action->execute('8.8.8.8');
=======
<<<<<<< HEAD
    $result = $action->execute('8.8.8.8');
=======
    $result = $this->action->execute('8.8.8.8');
>>>>>>> origin/dev
>>>>>>> Stashed changes

    expect($result)
        ->toBeInstanceOf(IPLocationData::class)
        ->and($result->ip)->toBe('8.8.8.8')
        ->and($result->city)->toBe('Ashburn')
        ->and($result->region)->toBe('Virginia')
        ->and($result->country)->toBe('US')
        ->and($result->countryName)->toBe('United States')
        ->and($result->latitude)->toBe(39.03)
        ->and($result->longitude)->toBe(-77.5)
        ->and($result->timezone)->toBe('America/New_York')
        ->and($result->isp)->toBe('Google LLC');
});

it('handles response with null values', function (): void {
<<<<<<< Updated upstream
    $this->mockHandler->append(new Response(200, [], json_encode([
        'status' => 'success',
    ])));

    $result = $this->action->execute('127.0.0.1');
=======
<<<<<<< HEAD
    $mockHandler->append(new Response(200, [], json_encode([)))
        'status' => 'success',
    ])));

    $result = $action->execute('127.0.0.1');
=======
    $this->mockHandler->append(new Response(200, [], json_encode([
        'status' => 'success',
    ])));

    $result = $this->action->execute('127.0.0.1');
>>>>>>> origin/dev
>>>>>>> Stashed changes

    expect($result)
        ->toBeInstanceOf(IPLocationData::class)
        ->and($result->ip)->toBe('127.0.0.1')
        ->and($result->city)->toBeNull()
        ->and($result->region)->toBeNull()
        ->and($result->country)->toBeNull();
});
