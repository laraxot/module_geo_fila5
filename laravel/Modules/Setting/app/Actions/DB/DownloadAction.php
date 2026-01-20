<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\Setting\Actions\DB;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Process as LaravelProcess;
use Illuminate\Support\Facades\Storage;
use Modules\Xot\Actions\File\CreateDirectoryForFilenameAction;
use Modules\Xot\Actions\File\FixPathAction;
use RuntimeException;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(string $connectionName): BinaryFileResponse
    {
        /**
         * @var array
         */
        $db = config('database.connections.'.$connectionName);

        // Type narrowing: ensure $db is array with required keys
        if (! is_array($db)) {
            throw new RuntimeException("Database configuration for connection '{$connectionName}' is not an array");
        }

        $username = isset($db['username']) && is_string($db['username']) ? $db['username'] : '';
        $password = isset($db['password']) && is_string($db['password']) ? $db['password'] : '';
        $database = isset($db['database']) && is_string($db['database']) ? $db['database'] : '';

        $filename = 'backup-'.$connectionName.'-'.Carbon::now()->format('Y-m-d').'.gz';
        $backup_path = Storage::disk('cache')->path('backup/'.$filename);
        $backup_path = app(FixPathAction::class)->execute($backup_path);
        app(CreateDirectoryForFilenameAction::class)->execute($backup_path);
        $command = sprintf('mysqldump --user=%s --password=%s %s | gzip > %s', $username, $password, $database, $backup_path);
        LaravelProcess::run($command);

        return response()->download($backup_path);
    }
}
