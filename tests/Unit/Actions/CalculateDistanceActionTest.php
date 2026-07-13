<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

<<<<<<< HEAD
use Modules\Geo\Actions\CalculateDistanceAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\DistanceCalculationException;
use Modules\Geo\Tests\Fixtures\CalculateDistanceMatrixActionStub;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
it('calculates distance between two valid locations', function (): void {
    $expectedResponse = [
        [
            [
                'distance' => ['text' => '572 km', 'value' => 572000],
                'duration' => ['text' => '5 ore 30 min', 'value' => 19800],
                'status' => 'OK',
            ],
        ],
    ];

    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub($expectedResponse));

=======
use Modules\Geo\Tests\TestCase;

uses(TestCase::class);

use Illuminate\Support\Collection;
use Modules\Geo\Actions\CalculateDistanceAction;
use Modules\Geo\Actions\GoogleMaps\CalculateDistanceMatrixAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\DistanceCalculationException;

beforeEach(function (): void {
    $this->mockDistanceMatrixAction = \Mockery::mock(CalculateDistanceMatrixAction::class);
    $this->action = new CalculateDistanceAction($this->mockDistanceMatrixAction);
});

afterEach(function () {
    \Mockery::close();
});

it('calculates distance between two valid locations', function (): void {
    // Arrange
>>>>>>> laraxot/dev
    $origin = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

<<<<<<< HEAD
    $result = $action->execute($origin, $destination);

    Assert::assertSame('572 km', $result['distance']['text']);
    Assert::assertSame(572000, $result['distance']['value']);
    Assert::assertSame('5 ore 30 min', $result['duration']['text']);
    Assert::assertSame(19800, $result['duration']['value']);
    Assert::assertSame('OK', $result['status']);
});

it('throws exception for invalid latitude', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    try {
        $action->execute(
            new LocationData(latitude: 100.0, longitude: 9.1900, address: 'Invalid Location'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Latitudine non valida: 100.000000', $exception->getMessage());
    }
});

it('throws exception for invalid longitude', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    try {
        $action->execute(
            new LocationData(latitude: 45.4642, longitude: 200.0, address: 'Milano, Italia'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Longitudine non valida: 200.000000', $exception->getMessage());
    }
});

it('throws exception for negative latitude', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    try {
        $action->execute(
            new LocationData(latitude: -100.0, longitude: 9.1900, address: 'Invalid Location'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Latitudine non valida: -100.000000', $exception->getMessage());
    }
});

it('throws exception for negative longitude', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    try {
        $action->execute(
            new LocationData(latitude: 45.4642, longitude: -200.0, address: 'Milano, Italia'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Longitudine non valida: -200.000000', $exception->getMessage());
    }
});

it('throws exception for empty response', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub([]));

    try {
        $action->execute(
            new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected DistanceCalculationException was not thrown');
    } catch (DistanceCalculationException $exception) {
        Assert::assertSame('Errore nel calcolo della distanza: Risposta non valida dal servizio di calcolo distanze', $exception->getMessage());
    }
});

it('throws exception for malformed response', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub([[]]));

    try {
        $action->execute(
            new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected DistanceCalculationException was not thrown');
    } catch (DistanceCalculationException $exception) {
        Assert::assertSame('Errore nel calcolo della distanza: Risposta non valida dal servizio di calcolo distanze', $exception->getMessage());
    }
});

it('throws exception when distance matrix fails', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub([], new \Exception('API Error')));

    try {
        $action->execute(
            new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected DistanceCalculationException was not thrown');
    } catch (DistanceCalculationException $exception) {
        Assert::assertSame('Errore nel calcolo della distanza: API Error', $exception->getMessage());
    }
});

it('formats distance in meters correctly', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    Assert::assertSame('500 m', $action->formatDistance(500));
});

it('formats distance in kilometers correctly', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    Assert::assertSame('1.5 km', $action->formatDistance(1500));
});

it('formats distance with decimal kilometers', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    Assert::assertSame('2.5 km', $action->formatDistance(2500));
});

it('formats exact kilometer distance', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    Assert::assertSame('1.0 km', $action->formatDistance(1000));
});

it('throws exception for negative distance', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    try {
        $action->formatDistance(-100);
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('La distanza non può essere negativa', $exception->getMessage());
    }
});

it('handles zero distance', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    Assert::assertSame('0 m', $action->formatDistance(0));
});

it('handles very small distances', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    Assert::assertSame('1 m', $action->formatDistance(1));
});

it('handles very large distances', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub());

    Assert::assertSame('1000.0 km', $action->formatDistance(999999));
});

it('handles boundary latitude values', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub([
=======
    $expectedResponse = [
        [
            [
                'distance' => ['text' => '572 km', 'value' => 572000],
                'duration' => ['text' => '5 ore 30 min', 'value' => 19800],
                'status' => 'OK',
            ],
        ],
    ];

    $this->mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->once()
        ->with(\Mockery::type(Collection::class), \Mockery::type(Collection::class))
        ->andReturn($expectedResponse);

    // Act
    $result = $this->action->execute($origin, $destination);

    // Assert
    expect($result)
        ->toBeArray()
        ->and($result['distance']['text'])
        ->toBe('572 km')
        ->and($result['distance']['value'])
        ->toBe(572000)
        ->and($result['duration']['text'])
        ->toBe('5 ore 30 min')
        ->and($result['duration']['value'])
        ->toBe(19800)
        ->and($result['status'])
        ->toBe('OK');
});

it('throws exception for invalid latitude', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 100.0, // Invalid latitude > 90
        longitude: 9.1900,
        address: 'Invalid Location',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    // Act & Assert
    expect(fn () => $this->action->execute($origin, $destination))
        ->toThrow(\InvalidArgumentException::class, 'Latitudine non valida: 100.000000');
});

it('throws exception for invalid longitude', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 45.4642,
        longitude: 200.0, // Invalid longitude > 180
        address: 'Milano, Italia',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    // Act & Assert
    expect(fn () => $this->action->execute($origin, $destination))
        ->toThrow(\InvalidArgumentException::class, 'Longitudine non valida: 200.000000');
});

it('throws exception for negative latitude', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: -100.0, // Invalid latitude < -90
        longitude: 9.1900,
        address: 'Invalid Location',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    // Act & Assert
    expect(fn () => $this->action->execute($origin, $destination))
        ->toThrow(\InvalidArgumentException::class, 'Latitudine non valida: -100.000000');
});

it('throws exception for negative longitude', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 45.4642,
        longitude: -200.0, // Invalid longitude < -180
        address: 'Milano, Italia',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    // Act & Assert
    expect(fn () => $this->action->execute($origin, $destination))
        ->toThrow(\InvalidArgumentException::class, 'Longitudine non valida: -200.000000');
});

it('throws exception for empty response', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    $this->mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->once()
        ->andReturn([]);

    // Act & Assert
    expect(fn () => $this->action->execute($origin, $destination));
});

it('throws exception for malformed response', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    $malformedResponse = [['invalid_structure']];

    $this->mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->once()
        ->andReturn($malformedResponse);

    // Act & Assert
    expect(fn () => $this->action->execute($origin, $destination));
});

it('throws exception when distance matrix fails', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    $this->mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->once()
        ->andThrow(new Exception('API Error'));

    // Act & Assert
    expect(fn () => $this->action->execute($origin, $destination))
        ->toThrow(DistanceCalculationException::class, 'Errore nel calcolo della distanza: API Error');
});

it('formats distance in meters correctly', function (): void {
    // Arrange
    $meters = 500;

    // Act
    $result = $this->action->formatDistance($meters);

    // Assert
    expect($result)->toBe('500 m');
});

it('formats distance in kilometers correctly', function (): void {
    // Arrange
    $meters = 1500;

    // Act
    $result = $this->action->formatDistance($meters);

    // Assert
    expect($result)->toBe('1.5 km');
});

it('formats distance with decimal kilometers', function (): void {
    // Arrange
    $meters = 2500;

    // Act
    $result = $this->action->formatDistance($meters);

    // Assert
    expect($result)->toBe('2.5 km');
});

it('formats exact kilometer distance', function (): void {
    // Arrange
    $meters = 1000;

    // Act
    $result = $this->action->formatDistance($meters);

    // Assert
    expect($result)->toBe('1.0 km');
});

it('throws exception for negative distance', function (): void {
    // Arrange
    $negativeMeters = -100;

    // Act & Assert
    expect(fn () => $this->action->formatDistance($negativeMeters))
        ->toThrow(\InvalidArgumentException::class, 'La distanza non può essere negativa');
});

it('handles zero distance', function (): void {
    // Arrange
    $zeroMeters = 0;

    // Act
    $result = $this->action->formatDistance($zeroMeters);

    // Assert
    expect($result)->toBe('0 m');
});

it('handles very small distances', function (): void {
    // Arrange
    $smallMeters = 1;

    // Act
    $result = $this->action->formatDistance($smallMeters);

    // Assert
    expect($result)->toBe('1 m');
});

it('handles very large distances', function (): void {
    // Arrange
    $largeMeters = 999999;

    // Act
    $result = $this->action->formatDistance($largeMeters);

    // Assert
    expect($result)->toBe('1000.0 km');
});

it('handles boundary latitude values', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 90.0, // Boundary value
        longitude: 9.1900,
        address: 'Boundary Location',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    $expectedResponse = [
>>>>>>> laraxot/dev
        [
            [
                'distance' => ['text' => '100 km', 'value' => 100000],
                'duration' => ['text' => '1 ora', 'value' => 3600],
                'status' => 'OK',
            ],
        ],
<<<<<<< HEAD
    ]));

    $result = $action->execute(
        new LocationData(latitude: 90.0, longitude: 9.1900, address: 'Boundary Location'),
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
    );

    Assert::assertSame('OK', $result['status']);
});

it('handles boundary longitude values', function (): void {
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub([
=======
    ];

    $this->mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->once()
        ->andReturn($expectedResponse);

    // Act
    $result = $this->action->execute($origin, $destination);

    // Assert
    expect($result)->toBeArray()->and($result['status'])->toBe('OK');
});

it('handles boundary longitude values', function (): void {
    // Arrange
    $origin = new LocationData(
        latitude: 45.4642,
        longitude: 180.0, // Boundary value
        address: 'Boundary Location',
    );

    $destination = new LocationData(
        latitude: 41.9028,
        longitude: 12.4964,
        address: 'Roma, Italia',
    );

    $expectedResponse = [
>>>>>>> laraxot/dev
        [
            [
                'distance' => ['text' => '100 km', 'value' => 100000],
                'duration' => ['text' => '1 ora', 'value' => 3600],
                'status' => 'OK',
            ],
        ],
<<<<<<< HEAD
    ]));

    $result = $action->execute(
        new LocationData(latitude: 45.4642, longitude: 180.0, address: 'Boundary Location'),
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
    );

    Assert::assertSame('OK', $result['status']);
});

it('handles same origin and destination', function (): void {
=======
    ];

    $this->mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->once()
        ->andReturn($expectedResponse);

    // Act
    $result = $this->action->execute($origin, $destination);

    // Assert
    expect($result)->toBeArray()->and($result['status'])->toBe('OK');
});

it('handles same origin and destination', function (): void {
    // Arrange
>>>>>>> laraxot/dev
    $sameLocation = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

<<<<<<< HEAD
    $action = new CalculateDistanceAction(new CalculateDistanceMatrixActionStub([
=======
    $expectedResponse = [
>>>>>>> laraxot/dev
        [
            [
                'distance' => ['text' => '0 m', 'value' => 0],
                'duration' => ['text' => '0 min', 'value' => 0],
                'status' => 'OK',
            ],
        ],
<<<<<<< HEAD
    ]));

    $result = $action->execute($sameLocation, $sameLocation);

    Assert::assertSame(0, $result['distance']['value']);
    Assert::assertSame(0, $result['duration']['value']);
=======
    ];

    $this->mockDistanceMatrixAction
        ->shouldReceive('execute')
        ->once()
        ->andReturn($expectedResponse);

    // Act
    $result = $this->action->execute($sameLocation, $sameLocation);

    // Assert
    expect($result)
        ->toBeArray()
        ->and($result['distance']['value'])
        ->toBe(0)
        ->and($result['duration']['value'])
        ->toBe(0);
>>>>>>> laraxot/dev
});
