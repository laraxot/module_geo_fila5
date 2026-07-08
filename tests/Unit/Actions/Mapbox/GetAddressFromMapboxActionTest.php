<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Mapbox;

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
use Modules\Geo\Actions\Mapbox\GetAddressFromMapboxAction;
use Modules\Geo\Datas\AddressData;
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

beforeEach(function () {
    $this->mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($this->mockHandler);
    $client = new Client(['handler' => $handlerStack]);
<<<<<<< Updated upstream
    $this->action = new GetAddressFromMapboxAction($client);
=======
    $action = new GetAddressFromMapboxAction($this->client);
=======
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\Mapbox\GetAddressFromMapboxAction;
use Modules\Geo\Datas\AddressData;
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

beforeEach(function () {
    $this->mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($this->mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $this->action = new GetAddressFromMapboxAction($client);
>>>>>>> origin/dev
>>>>>>> Stashed changes
});

it('throws exception when api key is not configured', function (): void {
    config(['services.mapbox.access_token' => null]);

<<<<<<< Updated upstream
    expect(fn () => $this->action->execute('Milano, Italia'))
=======
<<<<<<< HEAD
    expect(fn () => $action->execute('Milano, Italia'))
=======
    expect(fn () => $this->action->execute('Milano, Italia'))
>>>>>>> origin/dev
>>>>>>> Stashed changes
        ->toThrow(RuntimeException::class, 'Mapbox access token not configured');
});

it('throws exception for empty address', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

<<<<<<< Updated upstream
    expect(fn () => $this->action->execute(''))
=======
<<<<<<< HEAD
    expect(fn () => $action->execute(''))
=======
    expect(fn () => $this->action->execute(''))
>>>>>>> origin/dev
>>>>>>> Stashed changes
        ->toThrow(RuntimeException::class, 'Address cannot be empty');
});

it('throws exception for too long address', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

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
        ->toThrow(RuntimeException::class, 'Address is too long');
});

it('throws exception for guzzle exception', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

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

    expect($result)->toBeNull();
});

it('returns null when no features in response', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

<<<<<<< Updated upstream
    $this->mockHandler->append(new Response(200, [], json_encode([
        'features' => [],
    ])));

    $result = $this->action->execute('NonExistentPlace');
=======
<<<<<<< HEAD
    $mockHandler->append(new Response(200, [], json_encode([)))
        'features' => [],
    ])));

    $result = $action->execute('NonExistentPlace');
=======
    $this->mockHandler->append(new Response(200, [], json_encode([
        'features' => [],
    ])));

    $result = $this->action->execute('NonExistentPlace');
>>>>>>> origin/dev
>>>>>>> Stashed changes

    expect($result)->toBeNull();
});

it('returns address data for valid response', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

<<<<<<< Updated upstream
    $this->mockHandler->append(new Response(200, [], json_encode([
=======
<<<<<<< HEAD
    $mockHandler->append(new Response(200, [], json_encode([)))
=======
    $this->mockHandler->append(new Response(200, [], json_encode([
>>>>>>> origin/dev
>>>>>>> Stashed changes
        'features' => [[
            'center' => [9.1900, 45.4642],
            'context' => [
                ['id' => 'place.1', 'text' => 'Milano'],
                ['id' => 'region.1', 'short_code' => 'IT-MI'],
                ['id' => 'postcode.1', 'text' => '20100'],
            ],
            'place_name' => 'Via Roma 1, Milano, Lombardia 20100, Italia',
            'address' => '1',
            'text' => 'Via Roma',
        ]],
    ])));

<<<<<<< Updated upstream
    $result = $this->action->execute('Via Roma 1, Milano, Italia');
=======
<<<<<<< HEAD
    $result = $action->execute('Via Roma 1, Milano, Italia');
=======
    $result = $this->action->execute('Via Roma 1, Milano, Italia');
>>>>>>> origin/dev
>>>>>>> Stashed changes

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900)
        ->and($result->country)->toBe('Italia')
        ->and($result->city)->toBe('Milano')
        ->and($result->postal_code)->toBe(20100)
        ->and($result->street)->toBe('Via Roma')
        ->and($result->street_number)->toBe('1')
<<<<<<< Updated upstream
        ->and($result->province)->toBe('MI');
=======
<<<<<<< HEAD
        ->and($result->state)->toBe('MI');
=======
        ->and($result->province)->toBe('MI');
>>>>>>> origin/dev
>>>>>>> Stashed changes
});

it('handles address without house number', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

<<<<<<< Updated upstream
    $this->mockHandler->append(new Response(200, [], json_encode([
=======
<<<<<<< HEAD
    $mockHandler->append(new Response(200, [], json_encode([)))
=======
    $this->mockHandler->append(new Response(200, [], json_encode([
>>>>>>> origin/dev
>>>>>>> Stashed changes
        'features' => [[
            'center' => [9.1900, 45.4642],
            'context' => [
                ['id' => 'place.1', 'text' => 'Milano'],
            ],
            'place_name' => 'Via Roma, Milano, Italia',
            'text' => 'Via Roma',
        ]],
    ])));

<<<<<<< Updated upstream
    $result = $this->action->execute('Via Roma, Milano');
=======
<<<<<<< HEAD
    $result = $action->execute('Via Roma, Milano');
=======
    $result = $this->action->execute('Via Roma, Milano');
>>>>>>> origin/dev
>>>>>>> Stashed changes

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->street)->toBe('Via Roma')
        ->and($result->street_number)->toBe('');
});
