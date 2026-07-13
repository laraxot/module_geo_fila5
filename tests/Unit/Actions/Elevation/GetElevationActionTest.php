<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Elevation;

use Modules\Geo\Actions\Elevation\GetElevationAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\ElevationException;
<<<<<<< HEAD
use Modules\Geo\Tests\Fixtures\GoogleMapsServiceElevationStub;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);
it('gets elevation for valid location', function (): void {
    $action = new GetElevationAction(new GoogleMapsServiceElevationStub([
        'results' => [
            ['elevation' => 120.5, 'resolution' => 5.0],
        ],
    ]));

=======
use Modules\Geo\Services\GoogleMapsService;

beforeEach(function () {
    $mockGoogleMapsService = Mockery::mock(GoogleMapsService::class);
    $action = new GetElevationAction($this->mockGoogleMapsService);
});

afterEach(function () {
    Mockery::close();
});

it('gets elevation for valid location', function (): void {
    // Arrange
>>>>>>> laraxot/dev
    $location = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

<<<<<<< HEAD
    Assert::assertSame(120.5, $action->execute($location));
});

it('throws exception for invalid latitude', function (): void {
    $action = new GetElevationAction(new GoogleMapsServiceElevationStub());

    try {
        $action->execute(new LocationData(latitude: 100.0, longitude: 9.1900, address: 'Invalid Location'));
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertStringContainsString('Latitudine non valida', $exception->getMessage());
    }
});

it('throws exception for invalid longitude', function (): void {
    $action = new GetElevationAction(new GoogleMapsServiceElevationStub());

    try {
        $action->execute(new LocationData(latitude: 45.4642, longitude: 200.0, address: 'Invalid Location'));
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertStringContainsString('Longitudine non valida', $exception->getMessage());
    }
});

it('throws exception for negative latitude', function (): void {
    $action = new GetElevationAction(new GoogleMapsServiceElevationStub());

    try {
        $action->execute(new LocationData(latitude: -100.0, longitude: 9.1900, address: 'Invalid Location'));
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertStringContainsString('Latitudine non valida', $exception->getMessage());
    }
});

it('throws exception for negative longitude', function (): void {
    $action = new GetElevationAction(new GoogleMapsServiceElevationStub());

    try {
        $action->execute(new LocationData(latitude: 45.4642, longitude: -200.0, address: 'Invalid Location'));
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertStringContainsString('Longitudine non valida', $exception->getMessage());
    }
});

it('throws exception for empty response', function (): void {
    $action = new GetElevationAction(new GoogleMapsServiceElevationStub(['results' => []]));

    try {
        $action->execute(new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'));
        Assert::fail('Expected ElevationException was not thrown');
    } catch (ElevationException $exception) {
        Assert::assertSame('Nessun dato di elevazione trovato', $exception->getMessage());
    }
});

it('throws exception for invalid response structure', function (): void {
    $action = new GetElevationAction(new GoogleMapsServiceElevationStub(['results' => ['invalid']]));

    try {
        $action->execute(new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'));
        Assert::fail('Expected ElevationException was not thrown');
    } catch (ElevationException $exception) {
        Assert::assertSame('Struttura risposta elevazione non valida', $exception->getMessage());
    }
});

it('throws exception when service throws generic exception', function (): void {
    $action = new GetElevationAction(new GoogleMapsServiceElevationStub([], new \Exception('Network error')));

    try {
        $action->execute(new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'));
        Assert::fail('Expected ElevationException was not thrown');
    } catch (ElevationException $exception) {
        Assert::assertSame('Errore nel recupero dell\'elevazione', $exception->getMessage());
    }
});

it('formats elevation correctly', function (): void {
    $action = new GetElevationAction(new GoogleMapsServiceElevationStub());

    Assert::assertSame('1234.5 m s.l.m.', $action->formatElevation(1234.5));
});

it('formats elevation with zero value', function (): void {
    $action = new GetElevationAction(new GoogleMapsServiceElevationStub());

    Assert::assertSame('0.0 m s.l.m.', $action->formatElevation(0));
});

it('formats negative elevation correctly', function (): void {
    $action = new GetElevationAction(new GoogleMapsServiceElevationStub());

    Assert::assertSame('-430.0 m s.l.m.', $action->formatElevation(-430.0));
});

it('handles high elevation correctly', function (): void {
    $action = new GetElevationAction(new GoogleMapsServiceElevationStub());

    Assert::assertSame('8848.0 m s.l.m.', $action->formatElevation(8848.0));
});

it('handles boundary latitude values', function (): void {
    $action = new GetElevationAction(new GoogleMapsServiceElevationStub([
        'results' => [
            ['elevation' => 0.0, 'resolution' => 1.0],
        ],
    ]));

    Assert::assertSame(0.0, $action->execute(new LocationData(latitude: 90.0, longitude: 0.0, address: 'North Pole')));
=======
    $mockResponse = [
        'results' => [
            ['elevation' => 120.5, 'resolution' => 5.0],
        ],
    ];

    $mockGoogleMapsService
        ->shouldReceive('getElevation')
        ->once()
        ->with(45.4642, 9.1900)
        ->andReturn($mockResponse);

    // Act
    $result = $action->execute($location);

    // Assert
    expect($result)->toBe(120.5);
});

it('throws exception for invalid latitude', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: 100.0, // Invalid latitude > 90
        longitude: 9.1900,
        address: 'Invalid Location',
    );

    // Act & Assert
    expect(fn () => $action->execute($location))
        ->toThrow(InvalidArgumentException::class, 'Latitudine non valida');
});

it('throws exception for invalid longitude', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: 45.4642,
        longitude: 200.0, // Invalid longitude > 180
        address: 'Invalid Location',
    );

    // Act & Assert
    expect(fn () => $action->execute($location))
        ->toThrow(InvalidArgumentException::class, 'Longitudine non valida');
});

it('throws exception for negative latitude', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: -100.0,
        longitude: 9.1900,
        address: 'Invalid Location',
    );

    // Act & Assert
    expect(fn () => $action->execute($location))
        ->toThrow(InvalidArgumentException::class, 'Latitudine non valida');
});

it('throws exception for negative longitude', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: 45.4642,
        longitude: -200.0,
        address: 'Invalid Location',
    );

    // Act & Assert
    expect(fn () => $action->execute($location))
        ->toThrow(InvalidArgumentException::class, 'Longitudine non valida');
});

it('throws exception for empty response', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $mockGoogleMapsService
        ->shouldReceive('getElevation')
        ->once()
        ->andReturn(['results' => []]);

    // Act & Assert
    expect(fn () => $action->execute($location));
});

it('throws exception for invalid response structure', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $mockGoogleMapsService
        ->shouldReceive('getElevation')
        ->once()
        ->andReturn(['results' => ['invalid']]);

    // Act & Assert
    expect(fn () => $action->execute($location));
});

it('throws exception when service throws generic exception', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $mockGoogleMapsService
        ->shouldReceive('getElevation')
        ->once()
        ->andThrow(new Exception('Network error'));

    // Act & Assert
    expect(fn () => $action->execute($location))
        ->toThrow(ElevationException::class, 'Errore nel recupero dell\'elevazione');
});

it('formats elevation correctly', function (): void {
    // Act
    $result = $action->formatElevation(1234.5);

    // Assert
    expect($result)->toBe('1234.5 m s.l.m.');
});

it('formats elevation with zero value', function (): void {
    // Act
    $result = $action->formatElevation(0);

    // Assert
    expect($result)->toBe('0.0 m s.l.m.');
});

it('formats negative elevation correctly', function (): void {
    // Act (for locations below sea level like Dead Sea)
    $result = $action->formatElevation(-430.0);

    // Assert
    expect($result)->toBe('-430.0 m s.l.m.');
});

it('handles high elevation correctly', function (): void {
    // Act (Mount Everest)
    $result = $action->formatElevation(8848.0);

    // Assert
    expect($result)->toBe('8848.0 m s.l.m.');
});

it('handles boundary latitude values', function (): void {
    // Arrange
    $location = new LocationData(
        latitude: 90.0, // North pole
        longitude: 0.0,
        address: 'North Pole',
    );

    $mockResponse = [
        'results' => [
            ['elevation' => 0.0, 'resolution' => 1.0],
        ],
    ];

    $mockGoogleMapsService
        ->shouldReceive('getElevation')
        ->once()
        ->andReturn($mockResponse);

    // Act
    $result = $action->execute($location);

    // Assert
    expect($result)->toBe(0.0);
>>>>>>> laraxot/dev
});
