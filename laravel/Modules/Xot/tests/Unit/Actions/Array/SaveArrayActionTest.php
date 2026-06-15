<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Array;

use Modules\Xot\Actions\Array\SaveArrayAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\glob;
use function Safe\mkdir;
use function Safe\rmdir;
use function Safe\unlink;

uses(TestCase::class);

beforeEach(function (): void {
    $this->action = app(SaveArrayAction::class);
    $this->tempDir = sys_get_temp_dir().DIRECTORY_SEPARATOR.'pest_test_'.uniqid();
    if (! file_exists($this->tempDir)) {
        mkdir($this->tempDir, 0755, true);
    }
});

afterEach(function (): void {
    if (isset($this->tempDir) && file_exists($this->tempDir)) {
        $dir = $this->tempDir;
        $files = glob($dir.'/*');
        foreach ($files as $file) {
            $this->assertIsString($file);
            unlink($file);
        }
        rmdir($dir);
    }
});

describe('Save Array Action', function (): void {
    test('saves array in json format', function (): void {
        $path = $this->tempDir.'/data.json';

        $result = app(SaveArrayAction::class)->execute(['a' => 1], $path, 'json');

        Assert::assertTrue($result);
    });

    test('saves array in php format by default', function (): void {
        $path = $this->tempDir.'/data.php';

        $result = app(SaveArrayAction::class)->execute(['b' => 2], $path);
        Assert::assertSame(['b' => 2], $result);

        Assert::assertNotNull(require $path);
    });

    test('throws for unsupported format', function (): void {
        try {
            app(SaveArrayAction::class)->execute([], $this->tempDir.'/invalid.txt', 'xml');
            Assert::fail('Expected exception not thrown');
        } catch (\InvalidArgumentException) {
            // Expected
        }
    });
});
