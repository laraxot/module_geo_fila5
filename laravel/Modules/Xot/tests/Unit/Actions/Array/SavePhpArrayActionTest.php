<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Array;

use Modules\Xot\Actions\Array\SavePhpArrayAction;

beforeEach(function (): void {
    $this->action = app(SavePhpArrayAction::class);
    $this->tempDir = sys_get_temp_dir().DIRECTORY_SEPARATOR.'pest_test_'.uniqid();
    if (! file_exists($this->tempDir)) {
        mkdir($this->tempDir, 0755, true);
    }
});

afterEach(function (): void {
    if (isset($this->tempDir) && file_exists($this->tempDir)) {
        $files = glob($this->tempDir.'/*');
        if (false !== $files) {
            foreach ($files as $f) {
                unlink($f);
            }
        }
        rmdir($this->tempDir);
    }
});

it('saves array to php', function (): void {
    $path = $this->tempDir.'/d.php';
    $data = ['a' => 1];
    $result = $this->action->execute($data, $path);
    expect($result)->toBeTrue();
    expect(require $path)->toBe($data);
});
