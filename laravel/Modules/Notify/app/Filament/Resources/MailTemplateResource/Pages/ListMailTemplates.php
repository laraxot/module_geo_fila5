<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\MailTemplateResource\Pages;

use Filament\Tables\Columns\TextColumn;
use Modules\Lang\Filament\Resources\Pages\LangBaseListRecords;
use Modules\Notify\Filament\Resources\MailTemplateResource;
use Override;

class ListMailTemplates extends LangBaseListRecords
{
    protected static string $resource = MailTemplateResource::class;

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
            TextColumn::make('slug')->searchable()->sortable(),
            // TextColumn::make('mailable')->searchable()->sortable(),
            TextColumn::make('subject')->searchable()->sortable(),
            TextColumn::make('counter')->searchable()->sortable(),
        ];
    }
}
