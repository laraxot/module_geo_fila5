<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\MyLogResource\Pages;

use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\KeyValue;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Text;
use Modules\IndennitaResponsabilita\Filament\Resources\MyLogResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;
use Modules\Ptv\Filament\Resources\MyLogResource\Pages\ViewMyLog as PtvViewMyLog;

class ViewMyLog extends PtvViewMyLog
{
    protected static string $resource = MyLogResource::class;

}
