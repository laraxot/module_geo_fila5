<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\CalculateDistanceAction;
use Modules\Geo\Actions\GoogleMaps\CalculateDistanceMatrixAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\DistanceCalculationException;
use Modules\Geo\Tests\Fixtures\CalculateDistanceMatrixActionStub;
<<<<<<< .merge_file_ZE9jNL

/**
 * Bind the distance-matrix stub into the container and resolve the action
 * under test through the container, honouring the QueueableAction convention
 * (dependencies are resolved via app(), never injected through `new`).
 */
function makeCalculateDistanceAction(CalculateDistanceMatrixActionStub $stub): CalculateDistanceAction
{
    app()->instance(CalculateDistanceMatrixAction::class, $stub);

    return app(CalculateDistanceAction::class);
=======
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * @param CalculateDistanceMatrixAction $matrixAction
 */
function makeCalculateDistanceAction(CalculateDistanceMatrixAction $matrixAction): CalculateDistanceAction
{
    app()->instance(CalculateDistanceMatrixAction::class, $matrixAction);

    return new CalculateDistanceAction();
>>>>>>> .merge_file_Q49sRK
}

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

    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub($expectedResponse));

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

    $result = $action->execute($origin, $destination);

<<<<<<< .merge_file_ZE9jNL
    expect($result['distance']['text'])->toBe('572 km')
        ->and($result['distance']['value'])->toBe(572000)
        ->and($result['duration']['text'])->toBe('5 ore 30 min')
        ->and($result['duration']['value'])->toBe(19800)
        ->and($result['status'])->toBe('OK');
=======
    Assert::assertSame('572 km', $result['distance']['text']);
    Assert::assertSame(572000, $result['distance']['value']);
    Assert::assertSame('5 ore 30 min', $result['duration']['text']);
    Assert::assertSame(19800, $result['duration']['value']);
    Assert::assertSame('OK', $result['status']);
>>>>>>> .merge_file_Q49sRK
});

it('throws exception for invalid latitude', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

<<<<<<< .merge_file_ZE9jNL
    expect(fn (): array => $action->execute(
        new LocationData(latitude: 100.0, longitude: 9.1900, address: 'Invalid Location'),
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
    ))->toThrow(\InvalidArgumentException::class, 'Latitudine non valida: 100.000000');
=======
    try {
        $action->execute(
            new LocationData(latitude: 100.0, longitude: 9.1900, address: 'Invalid Location'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Latitudine non valida: 100.000000', $exception->getMessage());
    }
>>>>>>> .merge_file_Q49sRK
});

it('throws exception for invalid longitude', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

<<<<<<< .merge_file_ZE9jNL
    expect(fn (): array => $action->execute(
        new LocationData(latitude: 45.4642, longitude: 200.0, address: 'Milano, Italia'),
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
    ))->toThrow(\InvalidArgumentException::class, 'Longitudine non valida: 200.000000');
=======
    try {
        $action->execute(
            new LocationData(latitude: 45.4642, longitude: 200.0, address: 'Milano, Italia'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Longitudine non valida: 200.000000', $exception->getMessage());
    }
>>>>>>> .merge_file_Q49sRK
});

it('throws exception for negative latitude', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

<<<<<<< .merge_file_ZE9jNL
    expect(fn (): array => $action->execute(
        new LocationData(latitude: -100.0, longitude: 9.1900, address: 'Invalid Location'),
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
    ))->toThrow(\InvalidArgumentException::class, 'Latitudine non valida: -100.000000');
=======
    try {
        $action->execute(
            new LocationData(latitude: -100.0, longitude: 9.1900, address: 'Invalid Location'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Latitudine non valida: -100.000000', $exception->getMessage());
    }
>>>>>>> .merge_file_Q49sRK
});

it('throws exception for negative longitude', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

<<<<<<< .merge_file_ZE9jNL
    expect(fn (): array => $action->execute(
        new LocationData(latitude: 45.4642, longitude: -200.0, address: 'Milano, Italia'),
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
    ))->toThrow(\InvalidArgumentException::class, 'Longitudine non valida: -200.000000');
=======
    try {
        $action->execute(
            new LocationData(latitude: 45.4642, longitude: -200.0, address: 'Milano, Italia'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Longitudine non valida: -200.000000', $exception->getMessage());
    }
>>>>>>> .merge_file_Q49sRK
});

it('throws exception for empty response', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub([]));

<<<<<<< .merge_file_ZE9jNL
    expect(fn (): array => $action->execute(
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'),
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
    ))->toThrow(
        DistanceCalculationException::class,
        'Errore nel calcolo della distanza: Risposta non valida dal servizio di calcolo distanze',
    );
=======
    try {
        $action->execute(
            new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected DistanceCalculationException was not thrown');
    } catch (DistanceCalculationException $exception) {
        Assert::assertSame('Errore nel calcolo della distanza: Risposta non valida dal servizio di calcolo distanze', $exception->getMessage());
    }
>>>>>>> .merge_file_Q49sRK
});

it('throws exception for malformed response', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub([[]]));

<<<<<<< .merge_file_ZE9jNL
    expect(fn (): array => $action->execute(
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'),
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
    ))->toThrow(
        DistanceCalculationException::class,
        'Errore nel calcolo della distanza: Risposta non valida dal servizio di calcolo distanze',
    );
=======
    try {
        $action->execute(
            new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected DistanceCalculationException was not thrown');
    } catch (DistanceCalculationException $exception) {
        Assert::assertSame('Errore nel calcolo della distanza: Risposta non valida dal servizio di calcolo distanze', $exception->getMessage());
    }
>>>>>>> .merge_file_Q49sRK
});

it('throws exception when distance matrix fails', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub([], new \Exception('API Error')));

<<<<<<< .merge_file_ZE9jNL
    expect(fn (): array => $action->execute(
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'),
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
    ))->toThrow(DistanceCalculationException::class, 'Errore nel calcolo della distanza: API Error');
=======
    try {
        $action->execute(
            new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'),
            new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
        );
        Assert::fail('Expected DistanceCalculationException was not thrown');
    } catch (DistanceCalculationException $exception) {
        Assert::assertSame('Errore nel calcolo della distanza: API Error', $exception->getMessage());
    }
>>>>>>> .merge_file_Q49sRK
});

it('formats distance in meters correctly', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

<<<<<<< .merge_file_ZE9jNL
    expect($action->formatDistance(500))->toBe('500 m');
=======
    Assert::assertSame('500 m', $action->formatDistance(500));
>>>>>>> .merge_file_Q49sRK
});

it('formats distance in kilometers correctly', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

<<<<<<< .merge_file_ZE9jNL
    expect($action->formatDistance(1500))->toBe('1.5 km');
=======
    Assert::assertSame('1.5 km', $action->formatDistance(1500));
>>>>>>> .merge_file_Q49sRK
});

it('formats distance with decimal kilometers', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

<<<<<<< .merge_file_ZE9jNL
    expect($action->formatDistance(2500))->toBe('2.5 km');
=======
    Assert::assertSame('2.5 km', $action->formatDistance(2500));
>>>>>>> .merge_file_Q49sRK
});

it('formats exact kilometer distance', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

<<<<<<< .merge_file_ZE9jNL
    expect($action->formatDistance(1000))->toBe('1.0 km');
=======
    Assert::assertSame('1.0 km', $action->formatDistance(1000));
>>>>>>> .merge_file_Q49sRK
});

it('throws exception for negative distance', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

<<<<<<< .merge_file_ZE9jNL
    expect(fn (): string => $action->formatDistance(-100))
        ->toThrow(\InvalidArgumentException::class, 'La distanza non può essere negativa');
=======
    try {
        $action->formatDistance(-100);
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('La distanza non può essere negativa', $exception->getMessage());
    }
>>>>>>> .merge_file_Q49sRK
});

it('handles zero distance', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

<<<<<<< .merge_file_ZE9jNL
    expect($action->formatDistance(0))->toBe('0 m');
=======
    Assert::assertSame('0 m', $action->formatDistance(0));
>>>>>>> .merge_file_Q49sRK
});

it('handles very small distances', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

<<<<<<< .merge_file_ZE9jNL
    expect($action->formatDistance(1))->toBe('1 m');
=======
    Assert::assertSame('1 m', $action->formatDistance(1));
>>>>>>> .merge_file_Q49sRK
});

it('handles very large distances', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub());

<<<<<<< .merge_file_ZE9jNL
    expect($action->formatDistance(999999))->toBe('1000.0 km');
=======
    Assert::assertSame('1000.0 km', $action->formatDistance(999999));
>>>>>>> .merge_file_Q49sRK
});

it('handles boundary latitude values', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub([
        [
            [
                'distance' => ['text' => '100 km', 'value' => 100000],
                'duration' => ['text' => '1 ora', 'value' => 3600],
                'status' => 'OK',
            ],
        ],
    ]));

    $result = $action->execute(
        new LocationData(latitude: 90.0, longitude: 9.1900, address: 'Boundary Location'),
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
    );

<<<<<<< .merge_file_ZE9jNL
    expect($result['status'])->toBe('OK');
=======
    Assert::assertSame('OK', $result['status']);
>>>>>>> .merge_file_Q49sRK
});

it('handles boundary longitude values', function (): void {
    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub([
        [
            [
                'distance' => ['text' => '100 km', 'value' => 100000],
                'duration' => ['text' => '1 ora', 'value' => 3600],
                'status' => 'OK',
            ],
        ],
    ]));

    $result = $action->execute(
        new LocationData(latitude: 45.4642, longitude: 180.0, address: 'Boundary Location'),
        new LocationData(latitude: 41.9028, longitude: 12.4964, address: 'Roma, Italia'),
    );

<<<<<<< .merge_file_ZE9jNL
    expect($result['status'])->toBe('OK');
=======
    Assert::assertSame('OK', $result['status']);
>>>>>>> .merge_file_Q49sRK
});

it('handles same origin and destination', function (): void {
    $sameLocation = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

    $action = makeCalculateDistanceAction(new CalculateDistanceMatrixActionStub([
        [
            [
                'distance' => ['text' => '0 m', 'value' => 0],
                'duration' => ['text' => '0 min', 'value' => 0],
                'status' => 'OK',
            ],
        ],
    ]));

    $result = $action->execute($sameLocation, $sameLocation);

<<<<<<< .merge_file_ZE9jNL
    expect($result['distance']['value'])->toBe(0)
        ->and($result['duration']['value'])->toBe(0);
=======
    Assert::assertSame(0, $result['distance']['value']);
    Assert::assertSame(0, $result['duration']['value']);
>>>>>>> .merge_file_Q49sRK
});
