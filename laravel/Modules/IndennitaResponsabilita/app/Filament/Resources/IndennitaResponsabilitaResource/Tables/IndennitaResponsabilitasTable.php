<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Tables;

use Filament\Actions\Action;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Modules\IndennitaResponsabilita\Actions\MakePdfByRecord;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\Ptv\Filament\Actions\Bulk\SendSchedaBulkAction;
use Modules\Ptv\Filament\Actions\Bulk\ZipSchedaBulkAction;
use Modules\Ptv\Filament\Actions\Scheda\CompilaAction;
use Modules\Ptv\Filament\Actions\Table\RecordPdfAction;
use Modules\Ptv\Filament\Filters\AnnoValutatoreFilter;
use Modules\Ptv\Filament\Tables\Columns\PeriodoColumn;
use Modules\Ptv\Filament\Tables\Columns\WorkerColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class IndennitaResponsabilitasTable extends XotBaseResourceTable
{
    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'lavoratore' => WorkerColumn::make('lavoratore'),
            // RepColumn::make('rep'),
            // 'anno' => TextColumn::make('anno')->sortable()->searchable(),
            'periodo' => PeriodoColumn::make('periodo'),
            // 'sent_email_list' => TextColumn::make('sent_email_list')->html()->default(app(GetSentEmailListHtml::class)->execute(...)),
        ];
    }

    public function getTableFilters(): array
    {
        return [
            'anno_valutatore' => AnnoValutatoreFilter::make('anno_valutatore')
                ->columns(2),
            'is_compiled' => TernaryFilter::make('is_compiled')
                ->columns(2)
                ->queries(
                    true: function (Builder $query): Builder {
                        /** @var Builder<IndennitaResponsabilita> $query */
                        /** @var Builder<IndennitaResponsabilita> $result */
                        $result = $query->isCompiled();

                        return $result;
                    },
                    false: function (Builder $query): Builder {
                        /** @var Builder<IndennitaResponsabilita> $query */
                        /** @var Builder<IndennitaResponsabilita> $result */
                        $result = $query->isNotCompiled();

                        return $result;
                    },
                    blank: fn (Builder $query): Builder => $query, // In this example, we do not want to filter the query when it is blank.
                ),
        ];
    }

    public function getTableActions(): array
    {
        return [
            // Tables\Actions\ViewAction::make(),
            ...parent::getTableActions(),
            'compila' => CompilaAction::make(),
            'record-pdf1' => RecordPdfAction::make('record-pdf1')->visible(fn ($record): bool => Gate::allows('record-pdf', $record)),
            /*
            'record-pdf' => Action::make('record-pdf')
                ->icon('heroicon-o-document')
                // ->url( fn ($record): string => IndennitaResponsabilitaResource::getUrl('pdf', ['record' => $record])),
                ->action(app(MakePdfByRecord::class)->execute(...))
                ->visible(function ($record): bool {
                    // @var IndennitaResponsabilita $record
                    // @var \Illuminate\Database\Eloquent\Collection<int, Rating>|null $ratings
                    $ratings = $record->ratings;
                    if (null === $ratings) {
                        return false;
                    }
                    // @var float|int $sum
                    $sum = $ratings->sum('pivot.value');

                    return $sum > 0;
                }),
            */

            // Tables\Actions\EditAction::make(),
            // Action::make('activities')->url(fn ($record) => IndennitaResponsabilitaResource::getUrl('log-activity', ['record' => $record]))
            // 'log-activity' => ListLogActivitiesAction::make(), // Temporarily disabled - route registration issue
        ];
    }

    public function getTableBulkActions(): array
    {
        // dddx($this->tableFilters);
        /** @var array<string, mixed> $tableFilters */
        $tableFilters = $this->tableFilters ?? [];

        /** @var array<string, mixed> $annoValutatoreFilter */
        $annoValutatoreFilter = Arr::get($tableFilters, 'anno/valutatore', []);
        /** @var int|string|null $anno */
        $anno = Arr::get($annoValutatoreFilter, 'anno');

        /** @var non-falsy-string $tpl */
        $tpl = 'indennitaresponsabilita-'.(string) ($anno ?? '');

        return [
            'zip-schede' => ZipSchedaBulkAction::make('zip-schede'),
            'send-mail' => SendSchedaBulkAction::make('send-mail')->setTemplate($tpl),

        ];
    }
}
