<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Modules\Performance\Filament\Resources\OrganizzativaCatCoeffResource\Pages\CreateOrganizzativaCatCoeff;
use Modules\Performance\Filament\Resources\OrganizzativaCatCoeffResource\Pages\EditOrganizzativaCatCoeff;
use Modules\Performance\Filament\Resources\OrganizzativaCatCoeffResource\Pages\ListOrganizzativaCatCoeffs;
use Modules\Performance\Models\OrganizzativaCatCoeff;
use Modules\Xot\Actions\Filament\Filter\GetYearFilter;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

use function Safe\date;

class OrganizzativaCatCoeffResource extends XotBaseResource
{
    protected static ?string $model = OrganizzativaCatCoeff::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'lista_propro' => TextInput::make('lista_propro')
                ->maxLength(250),
            'coeff' => TextInput::make('coeff')
                ->numeric(),
            'descr' => Textarea::make('descr')
                ->columnSpanFull(),
            'tot_giorni' => TextInput::make('tot_giorni')
                ->numeric(),
            'tot_giorni_pt' => TextInput::make('tot_giorni_pt')
                ->numeric(),
            'tot_giorni_pt_coeff' => TextInput::make('tot_giorni_pt_coeff')
                ->numeric(),
            'quota_teorica' => TextInput::make('quota_teorica')
                ->numeric(),
            'anno' => TextInput::make('anno')
                ->numeric(),

        ];
    }

    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('lista_propro')
                ->searchable(),
            TextColumn::make('coeff')
                ->numeric()
                ->sortable(),
            TextColumn::make('tot_giorni')
                ->numeric()
                ->sortable(),
            TextColumn::make('tot_giorni_pt')
                ->numeric()
                ->sortable(),
            TextColumn::make('tot_giorni_pt_coeff')
                ->numeric()
                ->sortable(),
            TextColumn::make('quota_teorica')
                ->numeric()
                ->sortable(),
            TextColumn::make('anno')
                ->numeric()
                ->sortable(),

        ];
    }

    public static function getTableFilters(): array
    {
        return [
            app(GetYearFilter::class)
                ->execute('anno', intval(date('Y')) - 3, intval(date('Y'))),

        ];
    }

    public static function getTableActions(): array
    {
        return [
            EditAction::make(),

        ];
    }

    public static function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),

        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListOrganizzativaCatCoeffs::route('/'),
            'create' => CreateOrganizzativaCatCoeff::route('/create'),
            'edit' => EditOrganizzativaCatCoeff::route('/{record}/edit'),
        ];
    }
}
