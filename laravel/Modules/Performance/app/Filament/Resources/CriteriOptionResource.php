<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Performance\Filament\Resources\CriteriOptionResource\Pages\CreateCriteriOption;
use Modules\Performance\Filament\Resources\CriteriOptionResource\Pages\EditCriteriOption;
use Modules\Performance\Filament\Resources\CriteriOptionResource\Pages\ListCriteriOptions;
use Modules\Performance\Models\CriteriOption;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

use function Safe\date;

class CriteriOptionResource extends XotBaseResource
{
    protected static ?string $model = CriteriOption::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'name' => TextInput::make('name')

                ->required()
                ->maxLength(50),
            'value' => TextInput::make('value')

                ->required()
                ->maxLength(50),
            'anno' => TextInput::make('anno')

                ->required()
                ->numeric()
                ->default(date('Y')),
            'created_by' => TextInput::make('created_by')

                ->maxLength(50)
                ->disabled()
                ->dehydrated(false)
                ->hiddenOn('create'),

        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListCriteriOptions::route('/'),
            'create' => CreateCriteriOption::route('/create'),
            'edit' => EditCriteriOption::route('/{record}/edit'),
        ];
    }

    public function getTableColumns(): array
    {
        // Column types are inferred by Filament v4
        return [
            'name' => TextColumn::make('name')

                ->searchable()
                ->sortable(),
            'field_name' => TextColumn::make('field_name')

                ->searchable()
                ->sortable(),
            'op' => TextColumn::make('op')

                ->searchable()
                ->sortable(),
            'value' => TextColumn::make('value')

                ->searchable()
                ->sortable(),
            'anno' => TextColumn::make('anno')

                ->numeric()
                ->sortable(),

        ];
    }

    public function getTableActions(): array
    {
        return [
            EditAction::make(),

        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),

        ];
    }

    public static function getTableFilters(): array
    {
        return [
            app(GetYearFilter::class)
                ->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),

        ];
    }
}
