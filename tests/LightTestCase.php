<?php

declare(strict_types=1);

namespace Modules\Geo\Tests;

use Modules\Xot\Tests\XotBaseTestCase;

/**
 * @property object|null $action
 */
abstract class LightTestCase extends XotBaseTestCase
{
    public ?object $action = null;
}
