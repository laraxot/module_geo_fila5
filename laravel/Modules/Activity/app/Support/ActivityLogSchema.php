<?php

declare(strict_types=1);

namespace Modules\Activity\Support;

use Illuminate\Support\Facades\Schema;

/**
 * Verifica che activity_log sia scrivibile sulla connection configurata (Spatie v4+ richiede attribute_changes).
 */
final class ActivityLogSchema
{
    public static function isWritable(): bool
    {
        if (! config('activitylog.enabled', true)) {
            return false;
        }

        $schema = Schema::connection(self::resolveConnection());
        $table = self::resolveTable();

        return $schema->hasTable($table)
            && $schema->hasColumn($table, 'attribute_changes');
    }

    private static function resolveConnection(): string
    {
        $connection = config('activitylog.database_connection');
        if (is_string($connection) && $connection !== '') {
            return $connection;
        }

        $default = config('database.default');

        return is_string($default) ? $default : 'mysql';
    }

    private static function resolveTable(): string
    {
        $table = config('activitylog.table_name', 'activity_log');

        return is_string($table) && $table !== '' ? $table : 'activity_log';
    }
}
