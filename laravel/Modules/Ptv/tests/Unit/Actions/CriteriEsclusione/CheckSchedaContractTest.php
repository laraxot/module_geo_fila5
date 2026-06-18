<?php

declare(strict_types=1);

namespace Modules\Ptv\Tests\Unit\Actions\CriteriEsclusione;

use Illuminate\Support\Collection;
use InvalidArgumentException;
use Modules\Progressioni\Models\CriteriEsclusione;
use Modules\Progressioni\Models\Scheda;
use Modules\Ptv\Actions\CriteriEsclusione\Check;
use Modules\Ptv\Contracts\CheckCriterioEsclusioneContract;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\Ptv\Tests\TestCase;
use ReflectionMethod;

uses(TestCase::class);

describe('Check criteri esclusione', function (): void {
    it('accetta SchedaContract come primo argomento', function (): void {
        $method = new ReflectionMethod(Check::class, 'execute');
        $firstParam = $method->getParameters()[0];

        expect($firstParam->getType()?->getName())->toBe(SchedaContract::class);
    });

    it('allinea CheckCriterioEsclusioneContract su SchedaContract', function (): void {
        $method = new ReflectionMethod(CheckCriterioEsclusioneContract::class, 'execute');
        $firstParam = $method->getParameters()[0];

        expect($firstParam->getType()?->getName())->toBe(SchedaContract::class);
    });

    it('fallisce se un criterio non è Model', function (): void {
        $scheda = Scheda::make(['id' => 1]);

        expect(fn () => app(Check::class)->execute($scheda, [new \stdClass()], Collection::make()))
            ->toThrow(InvalidArgumentException::class, 'non è un Model Eloquent');
    });

    it('fallisce se manca action per name criterio', function (): void {
        $scheda = Scheda::make(['id' => 1]);
        $criterio = CriteriEsclusione::make([
            'id' => 99,
            'name' => 'criterio_inesistente_xyz',
            'value' => 1,
        ]);

        expect(fn () => app(Check::class)->execute($scheda, [$criterio], Collection::make()))
            ->toThrow(InvalidArgumentException::class, 'Action criterio esclusione non trovata');
    });
});
