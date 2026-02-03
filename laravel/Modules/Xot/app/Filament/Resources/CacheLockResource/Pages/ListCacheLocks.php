<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\CacheLockResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\CacheLockResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Override;

class ListCacheLocks extends XotBaseListRecords
{
    protected static string $resource = CacheLockResource::class;

    #[Override]
    public function getTableColumns(): array
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ...array_map(
                    fn($col) => is_object($col) ? $col : TextColumn::make($col),
                    $this->getTableColumns()
                )
            ]);
    }
    {
        return [
            'key' => TextColumn::make('key')
                ->searchable()
                ->sortable()
                ->wrap(),
            'owner' => TextColumn::make('owner')
                ->searchable()
                ->sortable()
                ->wrap(),
            'expiration' => TextColumn::make('expiration')->numeric()->sortable(),
        ];
    }
}
