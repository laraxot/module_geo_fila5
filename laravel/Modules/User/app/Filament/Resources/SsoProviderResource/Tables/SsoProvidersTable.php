<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\SsoProviderResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class SsoProvidersTable extends XotBaseResourceTable
{
    public function getTableFilters(): array
    {
        return [
            'type' => SelectFilter::make('type')->options([
                'saml' => 'SAML',
                'oidc' => 'OIDC',
                'oauth' => 'OAuth',
            ]),
            'is_active' => SelectFilter::make('is_active')->options([
                true => 'Active',
                false => 'Inactive',
            ]),
        ];
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'uuid' => TextColumn::make('uuid'),
            'name' => TextColumn::make('name')->searchable(),
            'slug' => TextColumn::make('slug'),
            'provider' => TextColumn::make('provider'),
            'is_active' => TextColumn::make('is_active')->badge(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(),
            'updated_by' => TextColumn::make('updated_by')->toggleable(),
            'created_by' => TextColumn::make('created_by')->toggleable(),
        ];
    }
}
