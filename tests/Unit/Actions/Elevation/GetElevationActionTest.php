<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Elevation;

use InvalidArgumentException;
use Mockery;
use Modules\Geo\Actions\Elevation\GetElevationAction;
use Modules\Geo\Actions\GoogleMaps\FetchGoogleMapsElevationAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\ElevationException;

beforeEach(function (): void {
    $this->mockFetchElevation = Mockery::mock(FetchGoogleMapsElevationAction::class);
    app()->instance(FetchGoogleMapsElevationAction::class, $this->mockFetchElevation);
    $this->action = app(GetElevationAction::class);
});

afterEach(function (): void {
    Mockery::close();
});

it('gets elevation for valid location', function (): void {
    $location = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $this->mockFetchElevation
        ->shouldReceive('execute')
        ->once()
        ->with(45.4642, 9.1900)
        ->andReturn([
            'results' => [
                ['elevation' => 120.5, 'resolution' => 5.0],
            ],
        ]);

    expect($this->action->execute($location))->toBe(120.5);
});

it('throws exception for invalid latitude', function (): void {
    $location = new LocationData(
        latitude: 100.0,
        longitude: 9.1900,
        address: 'Invalid Location',
    );

    expect(fn () => $this->action->execute($location))
        ->toThrow(InvalidArgumentException::class, 'Latitudine non valida');
});

it('throws exception for invalid longitude', function (): void {
    $location = new LocationData(
        latitude: 45.4642,
        longitude: 200.0,
        address: 'Invalid Location',
    );

    expect(fn () => $this->action->execute($location))
        ->toThrow(InvalidArgumentException::class, 'Longitudine non valida');
});

it('throws exception for negative latitude', function (): void {
    $location = new LocationData(
        latitude: -100.0,
        longitude: 9.1900,
        address: 'Invalid Location',
    );

    expect(fn () => $this->action->execute($location))
        ->toThrow(InvalidArgumentException::class, 'Latitudine non valida');
});

it('throws exception for negative longitude', function (): void {
    $location = new LocationData(
        latitude: 45.4642,
        longitude: -200.0,
        address: 'Invalid Location',
    );

    expect(fn () => $this->action->execute($location))
        ->toThrow(InvalidArgumentException::class, 'Longitudine non valida');
});

it('throws exception for empty response', function (): void {
    $location = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $this->mockFetchElevation
        ->shouldReceive('execute')
        ->once()
        ->andReturn(['results' => []]);

    expect(fn () => $this->action->execute($location))
        ->toThrow(ElevationException::class);
});

it('throws exception for invalid response structure', function (): void {
    $location = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $this->mockFetchElevation
        ->shouldReceive('execute')
        ->once()
        ->andReturn(['results' => ['invalid']]);

    expect(fn () => $this->action->execute($location))
        ->toThrow(ElevationException::class);
});

it('throws exception when fetch action throws generic exception', function (): void {
    $location = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $this->mockFetchElevation
        ->shouldReceive('execute')
        ->once()
        ->andThrow(new \Exception('Network error'));

    expect(fn () => $this->action->execute($location))
        ->toThrow(ElevationException::class, 'Errore nel recupero dell\'elevazione');
});

it('formats elevation correctly', function (): void {
    expect($this->action->formatElevation(1234.5))->toBe('1234.5 m s.l.m.');
});

it('formats elevation with zero value', function (): void {
    expect($this->action->formatElevation(0))->toBe('0.0 m s.l.m.');
});

it('formats negative elevation correctly', function (): void {
    expect($this->action->formatElevation(-430.0))->toBe('-430.0 m s.l.m.');
});

it('handles high elevation correctly', function (): void {
    expect($this->action->formatElevation(8848.0))->toBe('8848.0 m s.l.m.');
});

it('handles boundary latitude values', function (): void {
    $location = new LocationData(
        latitude: 90.0,
        longitude: 0.0,
        address: 'North Pole',
    );

    $this->mockFetchElevation
        ->shouldReceive('execute')
        ->once()
        ->andReturn([
            'results' => [
                ['elevation' => 0.0, 'resolution' => 1.0],
            ],
        ]);

    expect($this->action->execute($location))->toBe(0.0);
});
