<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\SchedeResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Modules\Progressioni\Actions\Populate;
use Modules\Progressioni\Filament\Resources\SchedeResource;
use Modules\Progressioni\Filament\Resources\SchedeResource\Actions\Header\MakePdfAction;
use Modules\Progressioni\Models\Schede;
use Modules\Ptv\Actions\FixValutatoreIdByAnno;
use Modules\Ptv\Actions\GetValutatoriOptions;
use Modules\Ptv\Filament\Actions\Bulk\SendSchedeBulkAction;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Actions\Filament\Actions\CopyFromLastYearButton;
use Modules\Xot\Filament\Actions\Header\ExportXlsAction;
use Modules\Xot\Filament\Actions\Table\PdfAction;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListSchedes extends XotBaseListRecords
{
    protected static string $resource = SchedeResource::class;

    #[Override]
    protected function getHeaderActions(): array
    {
        $anno = Arr::get($this->tableFilters ?? [], 'anno.value');

        return [
            // 'create' => Actions\CreateAction::make(),
            // 'copy' => app(CopyFromLastYearButton::class)
            //    ->execute(Schede::class, 'anno', $anno),
            'pdf' => MakePdfAction::make(),
            // 'export' => ExportXlsAction::make(), // da togliere campi etc etc
        ];
    }

    #[Override]
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')
                ->sortable(),
            GroupColumn::make('lavoratore')->schema([
                TextColumn::make('matr')->searchable(),
                TextColumn::make('cognome')->searchable(),
                TextColumn::make('nome'),
                TextColumn::make('email'),
            ])->searchable(['matr', 'cognome', 'nome', 'email']),
            /*
            'matr' => TextColumn::make('matr')
                ->searchable()
                ->sortable(),
            'cognome' => TextColumn::make('cognome')
                ->searchable()
                ->sortable(),
            'nome' => TextColumn::make('nome')
                ->searchable()
                ->sortable(),
            'email' => TextColumn::make('email')
                ->searchable()
                ->sortable(),
            */
            'ha_diritto' => IconColumn::make('ha_diritto')
                ->boolean()
                ->sortable(),
            'motivo' => TextColumn::make('motivo')
                ->wrap()
                ->sortable(),

            GroupColumn::make('qua')->schema([
                // TextColumn::make('propro'),
                // TextColumn::make('posfun'),
                // TextColumn::make('categoria_eco'),
                TextColumn::make('categoria_ecoval'),
                TextColumn::make('posfunval'),
                // TextColumn::make('posiz'),
                // TextColumn::make('posiz_txt'),
                TextColumn::make('disci1'),
                TextColumn::make('disci1_txt'),
            ]),
            /*
            'categoria_ecoval' => TextColumn::make('categoria_ecoval')
                ->searchable()
                ->sortable(),
            'posfunval' => TextColumn::make('posfunval')
                ->searchable()
                ->sortable(),
            'disci1' => TextColumn::make('disci1')
                ->searchable()
                ->sortable(),
            'disci1_txt' => TextColumn::make('disci1_txt')
                ->searchable()
                ->sortable(),
            */
            GroupColumn::make('rep')->schema([
                TextColumn::make('stabi'),
                TextColumn::make('stabi_txt'),
                TextColumn::make('repar'),
                TextColumn::make('repar_txt'),
            ]),
            /*
            'stabi' => TextColumn::make('stabi')
                ->searchable()
                ->sortable(),
            'stabi_txt' => TextColumn::make('stabi_txt')
                ->searchable()
                ->sortable(),
            'repar' => TextColumn::make('repar')
                ->searchable()
                ->sortable(),
            'repar_txt' => TextColumn::make('repar_txt')
                ->searchable()
                ->sortable(),
            */
            GroupColumn::make('periodo')->schema([
                TextColumn::make('dal'),
                TextColumn::make('al'),
                TextColumn::make('anno'),
            ]),
            /*
            'dal' => TextColumn::make('dal')
                ->sortable(),
            'al' => TextColumn::make('al')
                ->sortable(),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
            */
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            'updated_at' => TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    #[Override]
    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('anno/valutatore')
                ->label('anno/valutatore')
                ->schema([
                    Select::make('anno')
                        ->options([
                            // '2022' => '2022',
                            // '2023' => '2023',
                            '2024' => '2024',
                            '2025' => '2025',
                        ])
                        ->reactive()
                        ->live(),

                    Select::make('valutatore_id')
                        ->label('valutatore')
                        ->options(static fn (Get $get, Set $set) => app(GetValutatoriOptions::class)
                            ->execute('Progressioni', (string) ($get('anno') ?? ''))),
                ])

                ->query(static function (Builder $query, array $data): Builder {
                    /** @var int|string|null $anno */
                    $anno = $data['anno'] ?? null;
                    if ($anno === null /* || null == $data['valutatore_id'] */) {
                        return $query->where('id', 0);
                    }
                    // @var array{anno: int} $populateData
                    /*
                    $populateData = ['anno' => (int) $anno];
                    app(Populate::class)->execute($populateData);
                    app(FixValutatoreIdByAnno::class)->execute('Progressioni', 'Schede', $anno);
                    */
                    $query = $query->where($data);

                    return $query;
                })

                ->columns(4),
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

            'compila' => Action::make('compila')
                ->label('')
                ->tooltip('Compila scheda')
                ->icon('heroicon-m-pencil-square')
                ->iconButton()
                ->url(fn (Schede $record): string => SchedeResource::getUrl('compila', ['record' => $record]))

                ->visible(function (Schede $record): bool {
                    // @var bool|null $haDiritto
                    return (int) $record->ha_diritto > 0;
                }),
            'pdf' => PdfAction::make('pdf')
                ->visible(function (Schede $record): bool {
                    /* @var bool|null $haDiritto */
                    return (int) $record->ha_diritto > 0;
                }),

            // EditAction::make(),
            // Tables\Actions\EditAction::make(),
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
        $tpl = 'progressioni-'.(string) ($anno ?? '');

        return [
            // DeleteBulkAction::make(),
            'send_schede' => SendSchedeBulkAction::make()->setTemplate($tpl),
        ];
    }
}
