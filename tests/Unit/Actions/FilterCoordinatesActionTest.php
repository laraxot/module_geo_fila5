<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\FilterCoordinatesAction;
use Modules\Geo\Tests\TestCase;
<<<<<<< HEAD
use PHPUnit\Framework\Assert;

uses(TestCase::class);
it('filters coordinates within radius correctly', function (): void {
    $action = new FilterCoordinatesAction();

=======

uses(TestCase::class);
// Laraxot — see module docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.
// Laraxot module file — see docs/wiki for domain contract.

beforeEach(function () {
    $this->action = new FilterCoordinatesAction();
});

it('filters coordinates within radius correctly', function (): void {
>>>>>>> laraxot/dev
    $coordinates = [
        ['latitude' => 45.4642, 'longitude' => 9.1900], // Milano center
        ['latitude' => 45.4700, 'longitude' => 9.2000], // Close to center
        ['latitude' => 46.0000, 'longitude' => 10.0000], // Far away
    ];

    // Filter within 10km radius from Milano center
<<<<<<< HEAD
    $filtered = $action->execute($coordinates, 45.4642, 9.1900, 10.0);

    // Should return 2 coordinates (the center and the close one)
    Assert::assertCount(2, $filtered);

    // The first one should be the center point (distance 0)
    Assert::assertSame(45.4642, $filtered[0]['latitude']);
    Assert::assertSame(9.1900, $filtered[0]['longitude']);
    Assert::assertLessThan(0.1, abs($filtered[0]['distance'] - 0.0));

    // The second one should be the close point
    Assert::assertSame(45.4700, $filtered[1]['latitude']);
    Assert::assertSame(9.2000, $filtered[1]['longitude']);
    Assert::assertLessThan(10.0, $filtered[1]['distance']);
});

it('returns empty array when no coordinates are within radius', function (): void {
    $action = new FilterCoordinatesAction();

=======
    $filtered = $this->action->execute($coordinates, 45.4642, 9.1900, 10.0);

    // Should return 2 coordinates (the center and the close one)
    expect($filtered)->toHaveCount(2);

    // The first one should be the center point (distance 0)
    expect($filtered[0]['latitude'])->toBe(45.4642);
    expect($filtered[0]['longitude'])->toBe(9.1900);
    expect(abs($filtered[0]['distance'] - 0.0))->toBeLessThan(0.1);

    // The second one should be the close point
    expect($filtered[1]['latitude'])->toBe(45.4700);
    expect($filtered[1]['longitude'])->toBe(9.2000);
    expect($filtered[1]['distance'])->toBeLessThan(10.0);
});

it('returns empty array when no coordinates are within radius', function (): void {
>>>>>>> laraxot/dev
    $coordinates = [
        ['latitude' => 46.0000, 'longitude' => 10.0000], // Far away
        ['latitude' => 47.0000, 'longitude' => 11.0000], // Even farther
    ];

    // Filter within 1km radius from Milano center
<<<<<<< HEAD
    $filtered = $action->execute($coordinates, 45.4642, 9.1900, 1.0);
    Assert::assertCount(0, $filtered);
});

it('handles single coordinate within radius', function (): void {
    $action = new FilterCoordinatesAction();

=======
    $filtered = $this->action->execute($coordinates, 45.4642, 9.1900, 1.0);

    expect($filtered)->toBeArray()->toHaveCount(0);
});

it('handles single coordinate within radius', function (): void {
>>>>>>> laraxot/dev
    $coordinates = [
        ['latitude' => 45.4642, 'longitude' => 9.1900],
    ];

<<<<<<< HEAD
    $filtered = $action->execute($coordinates, 45.4642, 9.1900, 5.0);

    Assert::assertCount(1, $filtered);
    Assert::assertSame(45.4642, $filtered[0]['latitude']);
    Assert::assertSame(9.1900, $filtered[0]['longitude']);
    Assert::assertLessThan(0.1, abs($filtered[0]['distance'] - 0.0));
});

it('handles coordinates with string values', function (): void {
    $action = new FilterCoordinatesAction();

=======
    $filtered = $this->action->execute($coordinates, 45.4642, 9.1900, 5.0);

    expect($filtered)->toHaveCount(1);
    expect($filtered[0]['latitude'])->toBe(45.4642);
    expect($filtered[0]['longitude'])->toBe(9.1900);
    expect(abs($filtered[0]['distance'] - 0.0))->toBeLessThan(0.1);
});

it('handles coordinates with string values', function (): void {
>>>>>>> laraxot/dev
    $coordinates = [
        ['latitude' => '45.4642', 'longitude' => '9.1900'], // String values
        ['latitude' => '45.4700', 'longitude' => '9.2000'],
    ];

<<<<<<< HEAD
    $filtered = $action->execute($coordinates, 45.4642, 9.1900, 10.0);

    Assert::assertCount(2, $filtered);
});

it('throws exception for invalid center latitude', function (): void {
    $action = new FilterCoordinatesAction();

=======
    $filtered = $this->action->execute($coordinates, 45.4642, 9.1900, 10.0);

    expect($filtered)->toHaveCount(2);
    expect($filtered[0]['latitude'])->toBeFloat();
    expect($filtered[0]['longitude'])->toBeFloat();
});

it('throws exception for invalid center latitude', function (): void {
>>>>>>> laraxot/dev
    $coordinates = [
        ['latitude' => 45.4642, 'longitude' => 9.1900],
    ];

<<<<<<< HEAD
    try {
        $action->execute($coordinates, 91, 9.1900, 10.0);

        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Latitudine centrale non valida', $exception->getMessage());
    }
    try {
        $action->execute($coordinates, -91, 9.1900, 10.0);

        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Latitudine centrale non valida', $exception->getMessage());
    }
});

it('throws exception for invalid center longitude', function (): void {
    $action = new FilterCoordinatesAction();

=======
    expect(fn () => $this->action->execute($coordinates, 91, 9.1900, 10.0))
        ->toThrow(InvalidArgumentException::class, 'Latitudine centrale non valida');

    expect(fn () => $this->action->execute($coordinates, -91, 9.1900, 10.0))
        ->toThrow(InvalidArgumentException::class, 'Latitudine centrale non valida');
});

it('throws exception for invalid center longitude', function (): void {
>>>>>>> laraxot/dev
    $coordinates = [
        ['latitude' => 45.4642, 'longitude' => 9.1900],
    ];

<<<<<<< HEAD
    try {
        $action->execute($coordinates, 45.4642, 181, 10.0);

        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Longitudine centrale non valida', $exception->getMessage());
    }
    try {
        $action->execute($coordinates, 45.4642, -181, 10.0);

        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Longitudine centrale non valida', $exception->getMessage());
    }
});

it('throws exception for invalid radius', function (): void {
    $action = new FilterCoordinatesAction();

=======
    expect(fn () => $this->action->execute($coordinates, 45.4642, 181, 10.0))
        ->toThrow(InvalidArgumentException::class, 'Longitudine centrale non valida');

    expect(fn () => $this->action->execute($coordinates, 45.4642, -181, 10.0))
        ->toThrow(InvalidArgumentException::class, 'Longitudine centrale non valida');
});

it('throws exception for invalid radius', function (): void {
>>>>>>> laraxot/dev
    $coordinates = [
        ['latitude' => 45.4642, 'longitude' => 9.1900],
    ];

<<<<<<< HEAD
    try {
        $action->execute($coordinates, 45.4642, 9.1900, 0);

        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Il raggio deve essere maggiore di 0', $exception->getMessage());
    }
    try {
        $action->execute($coordinates, 45.4642, 9.1900, 30000);

        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Il raggio non può essere maggiore della circonferenza terrestre', $exception->getMessage());
    }
});

it('throws exception for invalid coordinate latitude', function (): void {
    $action = new FilterCoordinatesAction();

=======
    expect(fn () => $this->action->execute($coordinates, 45.4642, 9.1900, 0))
        ->toThrow(InvalidArgumentException::class, 'Il raggio deve essere maggiore di 0');

    expect(fn () => $this->action->execute($coordinates, 45.4642, 9.1900, 30000))
        ->toThrow(InvalidArgumentException::class, 'Il raggio non può essere maggiore della circonferenza terrestre');
});

it('throws exception for invalid coordinate latitude', function (): void {
>>>>>>> laraxot/dev
    $coordinates = [
        ['latitude' => 91, 'longitude' => 9.1900], // Invalid latitude
    ];

<<<<<<< HEAD
    try {
        $action->execute($coordinates, 45.4642, 9.1900, 10.0);

        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertStringContainsString('Latitudine non valida', $exception->getMessage());
    }
});

it('throws exception for invalid coordinate longitude', function (): void {
    $action = new FilterCoordinatesAction();

=======
    expect(fn () => $this->action->execute($coordinates, 45.4642, 9.1900, 10.0))
        ->toThrow(InvalidArgumentException::class, 'Latitudine non valida');
});

it('throws exception for invalid coordinate longitude', function (): void {
>>>>>>> laraxot/dev
    $coordinates = [
        ['latitude' => 45.4642, 'longitude' => 181], // Invalid longitude
    ];

<<<<<<< HEAD
    try {
        $action->execute($coordinates, 45.4642, 9.1900, 10.0);

        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertStringContainsString('Longitudine non valida', $exception->getMessage());
    }
});

it('sorts results by distance', function (): void {
    $action = new FilterCoordinatesAction();

=======
    expect(fn () => $this->action->execute($coordinates, 45.4642, 9.1900, 10.0))
        ->toThrow(InvalidArgumentException::class, 'Longitudine non valida');
});

it('sorts results by distance', function (): void {
>>>>>>> laraxot/dev
    $coordinates = [
        ['latitude' => 45.5000, 'longitude' => 9.2500], // Farther
        ['latitude' => 45.4700, 'longitude' => 9.2000], // Closer
        ['latitude' => 45.4642, 'longitude' => 9.1900], // Closest (center)
    ];

<<<<<<< HEAD
    $filtered = $action->execute($coordinates, 45.4642, 9.1900, 20.0);

    // Should be sorted by distance (closest first)
    Assert::assertCount(3, $filtered);
    Assert::assertLessThan($filtered[1]['distance'], $filtered[0]['distance']);
    Assert::assertLessThan($filtered[2]['distance'], $filtered[1]['distance']);
=======
    $filtered = $this->action->execute($coordinates, 45.4642, 9.1900, 20.0);

    // Should be sorted by distance (closest first)
    expect($filtered)->toHaveCount(3);
    expect($filtered[0]['distance'])->toBeLessThan($filtered[1]['distance']);
    expect($filtered[1]['distance'])->toBeLessThan($filtered[2]['distance']);
>>>>>>> laraxot/dev
});
