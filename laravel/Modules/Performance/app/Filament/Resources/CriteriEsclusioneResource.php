<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Modules\Performance\Filament\Resources\CriteriEsclusioneResource\Pages\CreateCriteriEsclusione;
use Modules\Performance\Filament\Resources\CriteriEsclusioneResource\Pages\EditCriteriEsclusione;
use Modules\Performance\Filament\Resources\CriteriEsclusioneResource\Pages\ListCriteriEsclusiones;
use Modules\Performance\Models\CriteriEsclusione;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

use function Safe\date;

class CriteriEsclusioneResource extends XotBaseResource
{
    protected static ?string $model = CriteriEsclusione::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->maxLength(50),
            'field_name' => TextInput::make('field_name')
                ->maxLength(50),
            'op' => TextInput::make('op')
                ->maxLength(50),
            'value' => TextInput::make('value')
                ->maxLength(50),
            'anno' => TextInput::make('anno')
                ->numeric(),
        ];
    }

    public static function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')
                ->searchable(),
            'field_name' => TextColumn::make('field_name')
                ->searchable(),
            'op' => TextColumn::make('op')
                ->searchable(),
            'value' => TextColumn::make('value')
                ->searchable(),
            'anno' => TextColumn::make('anno')
                ->numeric()
                ->sortable(),
        ];
    }

    public static function getTableFilters(): array
    {
        return [
            'anno' => app(GetYearFilter::class)
                ->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),
        ];
    }

    public static function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
        ];
    }

    public static function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListCriteriEsclusiones::route('/'),
            'create' => CreateCriteriEsclusione::route('/create'),
            'edit' => EditCriteriEsclusione::route('/{record}/edit'),
        ];
    }
}
