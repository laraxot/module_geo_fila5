<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Elevation;

use Modules\Geo\Actions\Elevation\GetElevationAction;
use Modules\Geo\Actions\GoogleMapsAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Exceptions\ElevationException;
use Modules\Geo\Tests\Fixtures\GoogleMapsServiceElevationStub;
use Modules\Geo\Tests\LightTestCase;
<<<<<<< .merge_file_AfVxbS
=======
use PHPUnit\Framework\Assert;
>>>>>>> .merge_file_vgh2YT

uses(LightTestCase::class);

/**
<<<<<<< .merge_file_AfVxbS
 * Bind the elevation service stub into the container and resolve the action
 * under test through it. GetElevationAction resolves GoogleMapsAction via
 * app(), so binding the stub is enough (QueueableAction convention: never
 * inject dependencies through `new`).
 */
function makeGetElevationAction(GoogleMapsServiceElevationStub $stub): GetElevationAction
{
    app()->instance(GoogleMapsAction::class, $stub);

    return app(GetElevationAction::class);
=======
 * @param GoogleMapsAction $mapsService
 */
function makeGetElevationAction(GoogleMapsAction $mapsService): GetElevationAction
{
    app()->instance(GoogleMapsAction::class, $mapsService);

    return new GetElevationAction();
>>>>>>> .merge_file_vgh2YT
}

it('gets elevation for valid location', function (): void {
    $action = makeGetElevationAction(new GoogleMapsServiceElevationStub([
        'results' => [
            ['elevation' => 120.5, 'resolution' => 5.0],
        ],
    ]));

    $location = new LocationData(
        latitude: 45.4642,
        longitude: 9.1900,
        address: 'Milano, Italia',
    );

<<<<<<< .merge_file_AfVxbS
    expect($action->execute($location))->toBe(120.5);
=======
    Assert::assertSame(120.5, $action->execute($location));
>>>>>>> .merge_file_vgh2YT
});

it('throws exception for invalid latitude', function (): void {
    $action = makeGetElevationAction(new GoogleMapsServiceElevationStub());

<<<<<<< .merge_file_AfVxbS
    expect(fn (): float => $action->execute(
        new LocationData(latitude: 100.0, longitude: 9.1900, address: 'Invalid Location'),
    ))->toThrow(\InvalidArgumentException::class, 'Latitudine non valida');
=======
    try {
        $action->execute(new LocationData(latitude: 100.0, longitude: 9.1900, address: 'Invalid Location'));
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertStringContainsString('Latitudine non valida', $exception->getMessage());
    }
>>>>>>> .merge_file_vgh2YT
});

it('throws exception for invalid longitude', function (): void {
    $action = makeGetElevationAction(new GoogleMapsServiceElevationStub());

<<<<<<< .merge_file_AfVxbS
    expect(fn (): float => $action->execute(
        new LocationData(latitude: 45.4642, longitude: 200.0, address: 'Invalid Location'),
    ))->toThrow(\InvalidArgumentException::class, 'Longitudine non valida');
=======
    try {
        $action->execute(new LocationData(latitude: 45.4642, longitude: 200.0, address: 'Invalid Location'));
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertStringContainsString('Longitudine non valida', $exception->getMessage());
    }
>>>>>>> .merge_file_vgh2YT
});

it('throws exception for negative latitude', function (): void {
    $action = makeGetElevationAction(new GoogleMapsServiceElevationStub());

<<<<<<< .merge_file_AfVxbS
    expect(fn (): float => $action->execute(
        new LocationData(latitude: -100.0, longitude: 9.1900, address: 'Invalid Location'),
    ))->toThrow(\InvalidArgumentException::class, 'Latitudine non valida');
=======
    try {
        $action->execute(new LocationData(latitude: -100.0, longitude: 9.1900, address: 'Invalid Location'));
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertStringContainsString('Latitudine non valida', $exception->getMessage());
    }
>>>>>>> .merge_file_vgh2YT
});

it('throws exception for negative longitude', function (): void {
    $action = makeGetElevationAction(new GoogleMapsServiceElevationStub());

<<<<<<< .merge_file_AfVxbS
    expect(fn (): float => $action->execute(
        new LocationData(latitude: 45.4642, longitude: -200.0, address: 'Invalid Location'),
    ))->toThrow(\InvalidArgumentException::class, 'Longitudine non valida');
=======
    try {
        $action->execute(new LocationData(latitude: 45.4642, longitude: -200.0, address: 'Invalid Location'));
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertStringContainsString('Longitudine non valida', $exception->getMessage());
    }
>>>>>>> .merge_file_vgh2YT
});

it('throws exception for empty response', function (): void {
    $action = makeGetElevationAction(new GoogleMapsServiceElevationStub(['results' => []]));

<<<<<<< .merge_file_AfVxbS
    expect(fn (): float => $action->execute(
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'),
    ))->toThrow(ElevationException::class, 'Risposta non valida dal servizio di elevazione');
=======
    try {
        $action->execute(new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'));
        Assert::fail('Expected ElevationException was not thrown');
    } catch (ElevationException $exception) {
        Assert::assertSame('Nessun dato di elevazione trovato', $exception->getMessage());
    }
>>>>>>> .merge_file_vgh2YT
});

it('throws exception for invalid response structure', function (): void {
    $action = makeGetElevationAction(new GoogleMapsServiceElevationStub(['results' => ['invalid']]));

<<<<<<< .merge_file_AfVxbS
    expect(fn (): float => $action->execute(
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'),
    ))->toThrow(ElevationException::class, 'Risposta non valida dal servizio di elevazione');
=======
    try {
        $action->execute(new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'));
        Assert::fail('Expected ElevationException was not thrown');
    } catch (ElevationException $exception) {
        Assert::assertSame('Struttura risposta elevazione non valida', $exception->getMessage());
    }
>>>>>>> .merge_file_vgh2YT
});

it('throws exception when service throws generic exception', function (): void {
    $action = makeGetElevationAction(new GoogleMapsServiceElevationStub([], new \Exception('Network error')));

<<<<<<< .merge_file_AfVxbS
    expect(fn (): float => $action->execute(
        new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'),
    ))->toThrow(ElevationException::class, 'Errore nel recupero dell\'elevazione');
=======
    try {
        $action->execute(new LocationData(latitude: 45.4642, longitude: 9.1900, address: 'Milano, Italia'));
        Assert::fail('Expected ElevationException was not thrown');
    } catch (ElevationException $exception) {
        Assert::assertSame('Errore nel recupero dell\'elevazione', $exception->getMessage());
    }
>>>>>>> .merge_file_vgh2YT
});

it('formats elevation correctly', function (): void {
    $action = makeGetElevationAction(new GoogleMapsServiceElevationStub());

<<<<<<< .merge_file_AfVxbS
    expect($action->formatElevation(1234.5))->toBe('1234.5 m s.l.m.');
=======
    Assert::assertSame('1234.5 m s.l.m.', $action->formatElevation(1234.5));
>>>>>>> .merge_file_vgh2YT
});

it('formats elevation with zero value', function (): void {
    $action = makeGetElevationAction(new GoogleMapsServiceElevationStub());

<<<<<<< .merge_file_AfVxbS
    expect($action->formatElevation(0))->toBe('0.0 m s.l.m.');
=======
    Assert::assertSame('0.0 m s.l.m.', $action->formatElevation(0));
>>>>>>> .merge_file_vgh2YT
});

it('formats negative elevation correctly', function (): void {
    $action = makeGetElevationAction(new GoogleMapsServiceElevationStub());

<<<<<<< .merge_file_AfVxbS
    expect($action->formatElevation(-430.0))->toBe('-430.0 m s.l.m.');
=======
    Assert::assertSame('-430.0 m s.l.m.', $action->formatElevation(-430.0));
>>>>>>> .merge_file_vgh2YT
});

it('handles high elevation correctly', function (): void {
    $action = makeGetElevationAction(new GoogleMapsServiceElevationStub());

<<<<<<< .merge_file_AfVxbS
    expect($action->formatElevation(8848.0))->toBe('8848.0 m s.l.m.');
=======
    Assert::assertSame('8848.0 m s.l.m.', $action->formatElevation(8848.0));
>>>>>>> .merge_file_vgh2YT
});

it('handles boundary latitude values', function (): void {
    $action = makeGetElevationAction(new GoogleMapsServiceElevationStub([
        'results' => [
            ['elevation' => 0.0, 'resolution' => 1.0],
        ],
    ]));

<<<<<<< .merge_file_AfVxbS
    expect($action->execute(new LocationData(latitude: 90.0, longitude: 0.0, address: 'North Pole')))->toBe(0.0);
=======
    Assert::assertSame(0.0, $action->execute(new LocationData(latitude: 90.0, longitude: 0.0, address: 'North Pole')));
>>>>>>> .merge_file_vgh2YT
});
