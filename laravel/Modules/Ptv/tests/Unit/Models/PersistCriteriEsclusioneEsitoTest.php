<?php

declare(strict_types=1);

namespace Modules\Ptv\Tests\Unit\Models;

use InvalidArgumentException;
use Modules\Progressioni\Models\Scheda;
use Modules\Ptv\Models\BaseScheda;
use Modules\Ptv\Tests\TestCase;

uses(TestCase::class);

/**
 * Stub senza ha_diritto/motivo in fillable — per test fail-fast.
 */
final class StubSchedaSenzaEsitoFillable extends BaseScheda
{
    /** @var list<string> */
    protected $fillable = ['ente', 'matr'];
}

describe('persistCriteriEsclusioneEsito', function (): void {
    it('richiede ha_diritto e motivo in fillable su Scheda Progressioni', function (): void {
        $fillable = (new Scheda())->getFillable();

        expect($fillable)->toContain('ha_diritto', 'motivo');
    });

    it('fallisce se ha_diritto o motivo non sono fillable', function (): void {
        $scheda = StubSchedaSenzaEsitoFillable::make(['id' => 1]);

        expect(fn () => $scheda->persistCriteriEsclusioneEsito(true, ''))
            ->toThrow(InvalidArgumentException::class, 'ha_diritto');
    });
});
