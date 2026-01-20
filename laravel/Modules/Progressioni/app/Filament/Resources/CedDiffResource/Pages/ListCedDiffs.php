<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\CedDiffResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Enums\RecordActionsPosition;
use Filament\Tables\Table;
use Modules\Progressioni\Filament\Imports\CedDiffImporter;
use Modules\Progressioni\Filament\Resources\CedDiffResource;
use Modules\Progressioni\Models\CedDiff;
use Modules\Progressioni\Models\Schede;
use Modules\Ptv\Filament\Resources\Pages\PtvBaseYearListRecords;
use Override;

class ListCedDiffs extends PtvBaseYearListRecords
{
    protected static string $resource = CedDiffResource::class;

    /**
     * @return array<string, Actions\Action>
     */
    #[Override]
    public function getHeaderActions(): array
    {
        return [
            'create' => CreateAction::make(),
            'import' => ImportAction::make()
                ->importer(CedDiffImporter::class)
                ->label(__('progressioni::messages.import_ced_diff')) // Traduzione
                ->modalHeading(__('progressioni::messages.import_modal_heading')) // Titolo della modale
                ->successNotificationTitle(__('progressioni::messages.import_success')) // Messaggio di successo
                ->color('success'), // Colore dell'azione
            'escludi' => Action::make('escludi da progressione')
                ->schema([
                    TextInput::make('anno')
                        ->numeric()
                        ->required(),
                ])
                ->action(function (array $data) {
                    $matricole = CedDiff::all()->pluck('matricola')->toArray();

                    $rows = Schede::where('anno', $data['anno'])
                        ->whereIn('matr', $matricole)
                        ->get();
                    foreach ($rows as $row) {
                        $motivo_arr = explode(',', (string) $row->motivo);
                        $motivo_arr[] = 'gradino';
                        $motivo_arr = array_unique($motivo_arr);
                        $motivo_arr = array_filter($motivo_arr);
                        /*
                        $row->update([
                            'ha_diritto'=>0,
                            'motivo'=>implode(',', $motivo_arr),
                        ]);
                        */
                        // dddx($row);
                        $row->ha_diritto = 0;
                        $row->motivo = implode(',', $motivo_arr);
                        $row->save();
                    }
                }),
        ];
    }

    #[Override]
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('matricola')->searchable()->sortable(),
            TextColumn::make('cognome')->searchable()->sortable(),
            TextColumn::make('nome')->searchable()->sortable(),
            TextColumn::make('dal')->sortable(),
            TextColumn::make('al')->sortable(),
            TextColumn::make('importo_forzato')->searchable()->sortable(),
            TextColumn::make('importo_base')->searchable()->sortable(),
            TextColumn::make('voce')->searchable()->sortable(),
            TextColumn::make('descrizione')->searchable()->sortable(),
            TextColumn::make('istituto')->searchable()->sortable(),
            TextColumn::make('tipo')->searchable()->sortable(),
            TextColumn::make('ruolo')->searchable()->sortable(),
            TextColumn::make('ruolo_txt')->searchable()->sortable(),
            TextColumn::make('profilo')->searchable()->sortable(),
            TextColumn::make('profilo_txt')->searchable()->sortable(),
            TextColumn::make('posizione_funzionale')->searchable()->sortable(),
            TextColumn::make('descr_posizione_funzionale')->searchable()->sortable(),
            TextColumn::make('stabilimento')->searchable()->sortable(),
            TextColumn::make('stabi_txt')->searchable()->sortable(),
            TextColumn::make('reparto')->searchable()->sortable(),
            TextColumn::make('repar_txt')->searchable()->sortable(),
        ];
    }

    #[Override]
    public function getTableFilters(): array
    {
        return [
        ];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    #[Override]
    public function getTableActions(): array
    {
        return [
            'view' => ViewAction::make()
                ->label(''),
            'edit' => EditAction::make()
                ->label(''),
            'delete' => DeleteAction::make()
                ->label('')
                ->requiresConfirmation(),
        ];
    }

    /**
     * @return array<string, BulkAction>
     */
    #[Override]
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }

    #[Override]
    public function table(Table $table): Table
    {
        $listColumns = $this->getTableColumns();
        $gridColumns = $listColumns; // Use same columns for both layouts

        return $table
            // ->columns($this->getTableColumns())
            ->columns($this->layoutView->getTableColumns($listColumns, $gridColumns))
            ->contentGrid($this->layoutView->getTableContentGrid())
            ->headerActions($this->getTableHeaderActions())

            ->filters($this->getTableFilters())
            ->filtersLayout(FiltersLayout::AboveContent)
            ->persistFiltersInSession()
            ->recordActions($this->getTableActions())
            ->toolbarActions($this->getTableBulkActions())
            ->recordActionsPosition(RecordActionsPosition::BeforeColumns)
            ->defaultSort(
                column: 'created_at',
                direction: 'DESC',
            );
    }
}
