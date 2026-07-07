<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Array;

use function Safe\file_put_contents;

use Spatie\QueueableAction\QueueableAction;

class SavePhpArrayAction
{
    use QueueableAction;

    /**
     * @param array<string, mixed> $data
     */
    public function execute(array<string, mixed> $data, string $filename): bool
    {
        $content = "<?php\n\nreturn ".var_export($data, true).";\n";

        return (bool) file_put_contents($filename, $content);
    }
}
