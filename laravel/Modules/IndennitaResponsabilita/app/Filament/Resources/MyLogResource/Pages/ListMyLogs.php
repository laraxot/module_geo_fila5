<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\MyLogResource\Pages;

use Filament\Tables;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Modules\IndennitaResponsabilita\Filament\Resources\MyLogResource;
use Modules\IndennitaResponsabilita\Models\MyLog;
use Modules\Ptv\Filament\Resources\MyLogResource\Pages\ListMyLogs as PtvListMyLogs;

class ListMyLogs extends PtvListMyLogs
{
    protected static string $resource = MyLogResource::class;
}