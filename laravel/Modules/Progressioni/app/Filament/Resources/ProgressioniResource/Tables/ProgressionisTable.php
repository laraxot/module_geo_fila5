<?php

declare(strict_types=1);

namespace Modules\Progressioni\Filament\Resources\ProgressioniResource\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Progressioni\Actions\ShowMailSendedAt;
use Modules\Progressioni\Filament\Actions\Bulk\SendMailBulkAction;
use Modules\Ptv\Filament\Actions\Bulk\ZipSchedaBulkAction;
use Modules\Ptv\Filament\Columns\QuaColumn;
use Modules\Ptv\Filament\Columns\RepartoColumn;
use Modules\Ptv\Filament\Columns\WorkerColumn;
use Modules\UI\Filament\Tables\Columns\GroupColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class ProgressionisTable extends XotBaseResourceTable
{
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id'),
            'cognome' => TextColumn::make('cognome')->toggleable(isToggledHiddenByDefault: true)->searchable(),
            'matr' => TextColumn::make('matr')->toggleable(isToggledHiddenByDefault: true)->searchable(),

            'ha_diritto' => IconColumn::make('ha_diritto')
                ->default(false)
                ->boolean(),

            'motivo' => TextColumn::make('motivo')
                // ->searchable() //diventa troppo lento
                ->wrap(),
            /* --------------------------- TROPPE QUERY ---------------------------- */
            /*
            Tables\Columns\TextColumn::make('mail_sended_at')
                ->html()
                ->default(fn ($record) => app(ShowMailSendedAt::class)->execute($record)),
            // */
            // ->formatStateUsing(fn (string $state) => dddx($state)),

            /*
                'diritto' => GroupColumn::make('diritto')->schema([
                    //Tables\Columns\TextColumn::make('ha_diritto'),
                    'ha_diritto' => IconColumn::make('ha_diritto')
                        ->default(false)
                        ->boolean(),
                    Tables\Columns\TextColumn::make('motivo')
                        ->wrap()
                        //->formatStateUsing(fn (string $state) => dddx($state))
                        //->listWithLineBreaks()
                        //->badge()
                        //->separator(','),
                ]),
                */
            'lavoratore' => WorkerColumn::make('lavoratore'),
            'criteri' => GroupColumn::make('criteri')->schema([
                'gg' => TextColumn::make('gg'),
                'gg_no_asz' => TextColumn::make('gg_no_asz'),
                'gg_asz' => TextColumn::make('gg_asz'),
                'gg_cateco_no_posfun_no_asz' => TextColumn::make('gg_cateco_no_posfun_no_asz'),
                'eta' => TextColumn::make('eta'),
            ]),
            'qualifica' => QuaColumn::make('qualifica'),
            'reparto' => RepartoColumn::make('reparto'),
            'periodo' => GroupColumn::make('periodo')->schema([
                'dal' => TextColumn::make('dal'),
                'al' => TextColumn::make('al'),
                'anno' => TextColumn::make('anno'),
            ]),
        ];
    }

    public function getTableActions(): array
    {
        // Types are inferred by Filament v4
        return [
            'edit' => EditAction::make()->label('')->tooltip('Modifica'),
            'view' => ViewAction::make()->label('')->tooltip('Vedi'),
            'activity-log' => ListLogActivitiesAction::make(),
        ];
    }

    public function getTableBulkActions(): array
    {
        // Types are inferred by Filament v4
        return [
            // Tables\Actions\BulkActionGroup::make([
            // Tables\Actions\DeleteBulkAction::make(),
            'send-mail' => SendMailBulkAction::make('send-mail'),
            'zip-schede' => ZipSchedaBulkAction::make('zip-schede'),
            // ]),
        ];
    }
}
