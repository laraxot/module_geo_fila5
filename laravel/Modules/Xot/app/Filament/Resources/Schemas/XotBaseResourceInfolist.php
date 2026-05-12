<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Schemas;

abstract class XotBaseResourceInfolist
{
    abstract public static function getInfolistSchema(): array;
}
