<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Pages;

use Filament\Resources\Pages\ManageRelatedRecords as FilamentManageRelatedRecords;
use Modules\Xot\Filament\Traits\HasXotTable;
use Modules\Xot\Filament\Traits\TransFuncTrait;

/**
 * ---
 */
abstract class XotBaseManageRelatedRecords extends FilamentManageRelatedRecords
{
    use HasXotTable;
    use TransFuncTrait;

    protected static string $recordTitleAttribute = 'name';

    public static function getNavigationLabel(): string
    {
        return static::transFunc(__FUNCTION__);
    }
}
