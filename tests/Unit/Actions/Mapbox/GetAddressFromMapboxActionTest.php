<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Mapbox;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\Mapbox\GetAddressFromMapboxAction;
<<<<<<< HEAD
use Modules\Geo\Datas\Geocoding\AddressData;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(LightTestCase::class);
it('throws exception when api key is not configured', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressFromMapboxAction($client);

    config(['services.mapbox.access_token' => null]);

    try {
        $action->execute('Milano, Italia');

        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Mapbox access token not configured', $exception->getMessage());
    }
});

it('throws exception for empty address', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressFromMapboxAction($client);

    config(['services.mapbox.access_token' => 'test_key']);

    try {
        $action->execute('');

        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Address cannot be empty', $exception->getMessage());
    }
});

it('throws exception for too long address', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressFromMapboxAction($client);

=======
use Modules\Geo\Datas\AddressData;
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

beforeEach(function () {
    $this->mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($this->mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $this->action = new GetAddressFromMapboxAction($client);
});

it('throws exception when api key is not configured', function (): void {
    config(['services.mapbox.access_token' => null]);

    expect(fn () => $this->action->execute('Milano, Italia'))
        ->toThrow(RuntimeException::class, 'Mapbox access token not configured');
});

it('throws exception for empty address', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

    expect(fn () => $this->action->execute(''))
        ->toThrow(RuntimeException::class, 'Address cannot be empty');
});

it('throws exception for too long address', function (): void {
>>>>>>> laraxot/dev
    config(['services.mapbox.access_token' => 'test_key']);

    $longAddress = str_repeat('a', 1001);

<<<<<<< HEAD
    try {
        $action->execute($longAddress);

        Assert::fail('Expected RuntimeException was not thrown');
    } catch (\RuntimeException $exception) {
        Assert::assertSame('Address is too long', $exception->getMessage());
    }
});

it('throws exception for guzzle exception', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressFromMapboxAction($client);

    config(['services.mapbox.access_token' => 'test_key']);

    $mockHandler->append(new RequestException('Error', new Request('GET', 'http://test')));

    $result = $action->execute('Milano, Italia');

    Assert::assertNull($result);
});

it('returns null when no features in response', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressFromMapboxAction($client);

    config(['services.mapbox.access_token' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
        'features' => [],
    ])));

    $result = $action->execute('NonExistentPlace');

    Assert::assertNull($result);
});

it('returns address data for valid response', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressFromMapboxAction($client);

    config(['services.mapbox.access_token' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
=======
    expect(fn () => $this->action->execute($longAddress))
        ->toThrow(RuntimeException::class, 'Address is too long');
});

it('throws exception for guzzle exception', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

    $this->mockHandler->append(new RequestException('Error', new Request('GET', 'http://test')));

    $result = $this->action->execute('Milano, Italia');

    expect($result)->toBeNull();
});

it('returns null when no features in response', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
        'features' => [],
    ])));

    $result = $this->action->execute('NonExistentPlace');

    expect($result)->toBeNull();
});

it('returns address data for valid response', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
>>>>>>> laraxot/dev
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

<<<<<<< HEAD
    $result = $action->execute('Via Roma 1, Milano, Italia');

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame(45.4642, $result->latitude);

    Assert::assertSame(9.1900, $result->longitude);

    Assert::assertSame('Italia', $result->country);

    Assert::assertSame('Milano', $result->city);

    Assert::assertSame(20100, $result->postal_code);

    Assert::assertSame('Via Roma', $result->street);

    Assert::assertSame('1', $result->street_number);

    Assert::assertSame('MI', $result->state);
});

it('handles address without house number', function (): void {
    $mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($mockHandler);
    $client = new Client(['handler' => $handlerStack]);
    $action = new GetAddressFromMapboxAction($client);

    config(['services.mapbox.access_token' => 'test_key']);

    $mockHandler->append(new Response(200, [], json_encode([
=======
    $result = $this->action->execute('Via Roma 1, Milano, Italia');

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900)
        ->and($result->country)->toBe('Italia')
        ->and($result->city)->toBe('Milano')
        ->and($result->postal_code)->toBe(20100)
        ->and($result->street)->toBe('Via Roma')
        ->and($result->street_number)->toBe('1')
        ->and($result->province)->toBe('MI');
});

it('handles address without house number', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
>>>>>>> laraxot/dev
        'features' => [[
            'center' => [9.1900, 45.4642],
            'context' => [
                ['id' => 'place.1', 'text' => 'Milano'],
            ],
            'place_name' => 'Via Roma, Milano, Italia',
            'text' => 'Via Roma',
        ]],
    ])));

<<<<<<< HEAD
    $result = $action->execute('Via Roma, Milano');

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame('Via Roma', $result->street);

    Assert::assertSame('', $result->street_number);
=======
    $result = $this->action->execute('Via Roma, Milano');

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->street)->toBe('Via Roma')
        ->and($result->street_number)->toBe('');
>>>>>>> laraxot/dev
});
