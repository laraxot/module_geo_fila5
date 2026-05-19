<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Tables;

abstract class XotBaseResourceTable
{
    /**
     * @return array<int\|string, \Filament\Tables\Columns\Column>
     */
    abstract public static function getTableColumns(): array;
}
