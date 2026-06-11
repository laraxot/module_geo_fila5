<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Nominatim;

uses(\Modules\Geo\Tests\TestCase::class);

use Exception;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use Modules\Geo\Tests\TestCase;
