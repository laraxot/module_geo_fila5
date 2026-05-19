<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\MailTemplateResource\Tables;

use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class MailTemplatesTable extends XotBaseResourceTable
{
<<<<<<< HEAD
    public static function getTableColumns(): array
=======
    public function getTableColumns(): array
>>>>>>> cc6378f (.)
    {
    /**
     * @return array<int\|string, \Filament\Tables\Columns\Column>
     */
        return [
            'id' => TextColumn::make('id')->searchable()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime(),
            'updated_at' => TextColumn::make('updated_at')->dateTime(),
        ];
    }
}
