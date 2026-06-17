<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\CriteriEsclusioneResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Ptv\Filament\Actions\Bulk\CheckCriterioEsclusioneBulkAction;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Filament\Resources\CriteriEsclusioneResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

use function Safe\date;

class ListCriteriEsclusiones extends BaseListCriteriEsclusiones
{
    protected static string $resource = CriteriEsclusioneResource::class;

   
}
