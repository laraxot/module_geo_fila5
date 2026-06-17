<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\CriteriEsclusioneResource\Tables;

use Filament\Actions\CreateAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Ptv\Filament\Actions\Bulk\CheckCriterioEsclusioneBulkAction;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

use function Safe\date;

class CriteriEsclusionesTable extends BaseCriteriEsclusionesTable
{
   
}
