<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

uses(\Modules\Geo\Tests\TestCase::class);

use Exception;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use function Safe\json_encode;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\App;
use Modules\Geo\Models\Comune;
use Modules\Geo\Tests\TestCase;
use Modules\Tenant\Services\TenantService;
use PHPUnit\Framework\Assert;
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

