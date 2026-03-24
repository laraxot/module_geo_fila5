<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\IndividualeResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Widgets\WidgetConfiguration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Modules\Performance\Actions\ShowMailSendedAt;
use Modules\Performance\Filament\Actions\Bulk\SendMailBulkAction;
use Modules\Performance\Filament\Actions\Header\CopyFromOrganizzativaAction;
use Modules\Performance\Filament\Resources\IndividualeResource;
use Modules\Performance\Models\StabiDirigente;
use Modules\Ptv\Filament\Actions\Bulk\ZipSchedaBulkAction;
use Modules\Ptv\Filament\Actions\Header\CopyFromLastYearAction;
use Modules\Ptv\Filament\Actions\Header\PopulateYearAction;
use Modules\Ptv\Filament\Columns\LavoratoreColumn;
use Modules\Ptv\Filament\Columns\PeriodoColumn;
use Modules\Ptv\Filament\Columns\QualificaColumn;
use Modules\Ptv\Filament\Columns\RepartoColumn;
use Modules\Ptv\Filament\Filters\AnnoValutatoreFilter;
use Modules\Ptv\Filament\Resources\ReportResource\Widgets\FirmaValutatoreWidget;
use Modules\Ptv\Filament\Resources\SchedaResource\Pages\ListScheda;
use Modules\UI\Filament\Tables\Columns\GroupColumn;

use function Safe\date;

/**
 * ---.
 */
class ListIndividuales extends ListScheda
{
    protected static string $resource = IndividualeResource::class;

    /** @var array<string, mixed> */
    protected array $data = [];

    /**
     * @return array<string, Action|ActionGroup>
     */
    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            'copy_from_organizzativa' => CopyFromOrganizzativaAction::make('copy_from_organizzativa'),
        ];
    }

    

   

   
    
}
