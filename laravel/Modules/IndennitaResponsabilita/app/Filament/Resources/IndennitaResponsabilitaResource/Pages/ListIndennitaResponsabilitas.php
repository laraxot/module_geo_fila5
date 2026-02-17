<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Select;
use Filament\Pages\Actions\CreateAction;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Tables;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
// use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\IndennitaResponsabilita\Actions\MakePdf;
use Modules\IndennitaResponsabilita\Actions\MakePdfByRecord;
use Modules\IndennitaResponsabilita\Filament\Exports\IndennitaResponsabilitaExporter;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\Ptv\Actions\FixValutatoreIdByAnno;
use Modules\Ptv\Actions\GetValutatoriOptions;
use Modules\Ptv\Actions\PopulateByYearAction;
use Modules\Ptv\Actions\Scheda\GetSentEmailListHtml;
use Modules\Ptv\Filament\Actions\Bulk\SendSchedeBulkAction;
use Modules\Ptv\Filament\Actions\Bulk\ZipSchedeBulkAction;
use Modules\Ptv\Filament\Actions\Header\DeleteCessatiAction;
use Modules\Ptv\Filament\Actions\Table\RecordPdfAction;
use Modules\Ptv\Filament\Tables\Columns\PeriodoColumn;
use Modules\Ptv\Filament\Tables\Columns\RepColumn;
use Modules\Ptv\Filament\Tables\Columns\WorkerColumn;
use Modules\Xot\Filament\Actions\Header\ExportXlsAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ListIndennitaResponsabilitas extends XotBaseListRecords
{
    protected static string $resource = IndennitaResponsabilitaResource::class;

    /**
     * @return array<string, Action>
     */
    #[Override]
    protected function getHeaderActions(): array
    {
        // dddx($this->getTableQuery());
        /** @var array<string, string|int|bool|null>|null $tableFilters */
        $tableFilters = $this->tableFilters;
        /** @var array<string, string|int|bool|null> $filtersForPdf */
        $filtersForPdf = $tableFilters ?? [];
        /** @var array<string, string|int|bool|null>|null $filtersForUrl */
        $filtersForUrl = $this->tableFilters;

        return [

            'exportPdf' => Action::make('exportPdf')
                ->icon('heroicon-s-document')
                ->action(function (): BinaryFileResponse {
                    /** @var array<string, mixed> $tableFilters */
                    $tableFilters = $this->tableFilters ?? [];

                    return app(MakePdf::class)->execute($tableFilters);
                }),

            'SendMail' => Action::make('SendMail')
                ->icon('heroicon-o-paper-airplane')
                ->url(fn () => IndennitaResponsabilitaResource::getUrl('send-mail', $filtersForUrl ?? []))
                ->visible(false),
            'DeleteCessatiAction' => DeleteCessatiAction::make(),

            // CreateAction::make(),
            /*
            Actions\ExportAction::make()
               ->exporter(IndennitaResponsabilitaExporter::class)
               ->tooltip('esporta xls')
               ->icon('fas-file-excel')
               ->modifyQueryUsing(function ($query) {
                   return $this->getTableQuery();
               }),
            */
            'exportXls' => ExportXlsAction::make('exportXls'),
            // ->exportOnlyFiltered(),
        ];
    }

    /**
     * @return array<int|string, Column>
     */
    #[Override]
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

    /**
     * @return array<string, BulkAction>
     */
    #[Override]
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
            'zip-schede' => ZipSchedeBulkAction::make('zip-schede'),
            'send-mail' => SendSchedeBulkAction::make('send-mail')->setTemplate($tpl),

        ];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    #[Override]
    public function getTableActions(): array
    {
        return [
            // Tables\Actions\ViewAction::make(),
            ...parent::getTableActions(),
            'compila' => Action::make('compila')
                ->icon('heroicon-m-pencil-square')
                ->url(fn ($record): string => IndennitaResponsabilitaResource::getUrl('compila', ['record' => $record])),
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

    /*
    protected function getTableFiltersLayout(): ?string
    {
        return FiltersLayout::AboveContent;
    }

    protected function getTableFiltersFormColumns(): int
    {
        return 1;
    }

    protected function getTableFiltersFormWidth(): string
    {
        return '4xl';
    }

    protected function shouldPersistTableFiltersInSession(): bool
    {
        return true;
    }
    */
    /**
     * @return array<string, SelectFilter|TernaryFilter>
     */
    #[Override]
    public function getTableFilters(): array
    {
        return [
            'anno_valutatore' => SelectFilter::make('anno/valutatore')
                ->schema([
                    'anno' => Select::make('anno')
                        ->options([
                            // '2022' => '2022',
                            '2023' => '2023',
                            '2024' => '2024',
                            '2025' => '2025',
                        ])
                        ->reactive(),

                    'valutatore_id' => Select::make('valutatore_id')
                        ->options(static function (Get $get): array {
                            /** @var int|string|null $anno */
                            $anno = $get('anno');

                            $opts = app(GetValutatoriOptions::class)
                                ->execute('IndennitaResponsabilita', $anno);

                            return $opts;
                        }),
                ])

                ->query(static function (Builder $query, array $data) {
                    if ($data['anno'] == null /* || null == $data['valutatore_id'] */) {
                        return $query->where('id', 0);
                    }
                    // Type narrowing: ensure $data is array<string, mixed>
                    // @var array<string, mixed> $populateData
                    /*
                    app(PopulateByYearAction::class)->execute(IndennitaResponsabilita::class, 'anno', (int) $data['anno']);
                    // -- riutilizzabile in performance, progressioni ...
                    // @var int|string|null $annoForFix
                    $annoForFix = $data['anno'] ?? null;
                    app(FixValutatoreIdByAnno::class)->execute('IndennitaResponsabilita', 'IndennitaResponsabilita', $annoForFix);
                    */
                    $query = $query->where($data);

                    return $query;
                })

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

    #[Override]
    public function getTableFiltersFormColumns(): int
    {
        return 2;
    }
}
