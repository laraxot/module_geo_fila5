<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Illuminate\Support\Facades\App;
use Modules\Geo\Tests\TestCase;
use Modules\Tenant\Services\TenantService;

uses(TestCase::class);
/**
 * @return list<array<string, mixed>>
 */
function comuneTestRows(): array
{
    return [
        [
            'id' => 1,
            'regione' => 'Lombardia',
            'provincia' => 'Milano',
            'nome' => 'Milano',
            'cap' => '20100',
            'lat' => 45.4642,
            'lng' => 9.1900,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'id' => 2,
            'regione' => 'Lombardia',
            'provincia' => 'Milano',
            'nome' => 'Sesto San Giovanni',
            'cap' => '20099',
            'lat' => 45.5347,
            'lng' => 9.2345,
            'created_at' => now(),
            'updated_at' => now(),
        ],
    ];
}

function comuneJsonPath(): string
{
    return App::make(TenantService::class)->filePath('database/content/comuni.json');
}
