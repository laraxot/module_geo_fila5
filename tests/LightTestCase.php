<?php

declare(strict_types=1);

namespace Modules\Geo\Tests;

use Exception;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * @property object|null $action
 */
abstract class LightTestCase extends XotBaseTestCase
{
    public ?object $action = null;
}
