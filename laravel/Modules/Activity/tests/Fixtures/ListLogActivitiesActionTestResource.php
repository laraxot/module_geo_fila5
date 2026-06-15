<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

final class ListLogActivitiesActionTestResource
{
    /**
     * @param  array<string, mixed>  $parameters
     */
    public static function getUrl(string $name, array $parameters = []): string
    {
        $record = $parameters['record'] ?? null;
        $key = $record instanceof Model ? (string) $record->getKey() : '';

        return '/log-activity/'.$name.'/'.$key;
    }
}
