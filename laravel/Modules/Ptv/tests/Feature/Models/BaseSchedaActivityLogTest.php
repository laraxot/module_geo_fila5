<?php

declare(strict_types=1);

use Modules\Ptv\Models\BaseScheda;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\Ptv\Models\Scheda;
use PHPUnit\Framework\Assert;

test('ptv scheda extends base scheda and implements the scheda contract', function (): void {
    Assert::assertTrue(is_subclass_of(Scheda::class, BaseScheda::class));
    Assert::assertTrue(is_subclass_of(Scheda::class, SchedaContract::class));
});

test('ptv scheda exposes canonical range fields', function (): void {
    $scheda = new Scheda();

    Assert::assertSame('matr', $scheda->matrField());
    Assert::assertSame('ente', $scheda->enteField());
    Assert::assertSame('anno', $scheda->yearField());
    Assert::assertSame('dal', $scheda->rangeFromField());
    Assert::assertSame('al', $scheda->rangeToField());
});
