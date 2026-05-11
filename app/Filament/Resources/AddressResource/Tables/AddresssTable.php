<?php

declare(strict_types=1);

namespace Modules\base_quaeris_fila5\var\www\_bases\base_quaeris_fila5\laravel\Modules\Geo\app\Filament\Resources\AddressResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class AddresssTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public static function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }
}
