<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Filament\Resources\MyLogResource\Pages\ListMyLogs;
use Modules\Ptv\Filament\Resources\MyLogResource\Pages\ViewMyLog;
use Modules\Ptv\Models\MyLog;
use Modules\Xot\Filament\Resources\XotBaseResource;

class MyLogResource extends XotBaseResource
{
    protected static ?string $model = MyLog::class;

    protected static ?int $navigationSort = 99;

    /**
     * Get the form schema definition.
     *
     * @return array<int, \Filament\Support\Components\Component>
     */
    public static function getFormSchema(): array
    {
        return [
            Section::make('Dettagli Log')
                ->columnSpanFull()
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('id_tbl')
                                ->numeric()
                                ->disabled(),

                            TextInput::make('tbl')
                                ->maxLength(255)
                                ->disabled(),
                        ]),

                    Grid::make(2)
                        ->schema([
                            TextInput::make('obj')
                                ->maxLength(255)
                                ->disabled(),

                            TextInput::make('act')
                                ->maxLength(255)
                                ->disabled(),
                        ]),

                    Textarea::make('note')
                        ->rows(3)
                        ->columnSpanFull(),

                    KeyValue::make('data')
                        ->columnSpanFull(),

                    Grid::make(2)
                        ->schema([
                            TextInput::make('created_by')
                                ->maxLength(255)
                                ->disabled(),

                            TextInput::make('created_at')
                                ->disabled(),
                        ]),
                ]),
        ];
    }

    /**
     * Get the pages definition.
     *
     * @return array<string, \Filament\Resources\Pages\PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListMyLogs::route('/'),
            'view' => ViewMyLog::route('/{record}'),
        ];
    }

    /**
     * Get the Eloquent query builder.
     *
     * @return Builder<MyLog>
     */
    public static function getEloquentQuery(): Builder
    {
        /** @var Builder<MyLog> $query */
        $query = parent::getEloquentQuery();

        return $query->orderBy('created_at', 'desc');
    }
}
