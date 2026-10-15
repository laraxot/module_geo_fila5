<?php

declare(strict_types=1);

namespace Tests\Modules\Geo\Support;

final class GeoMapDatasetFixture
{
    public static function path(): string
    {
        return __DIR__.'/fixtures/test-dataset.json';
    }
}
