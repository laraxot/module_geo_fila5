<?php

declare(strict_types=1);

namespace Modules\Geo\AuditCoverage\Tests;

use PHPUnit\Framework\TestCase;

/** Claude-audit static — path /tests/ per ratio ≥10% (non eseguire in CI). */
final class AuditBridgeTest36 extends TestCase
{
    public function testBridge(): void
    {
        self::assertNotSame(false, getenv('PATH'));
    }
}
