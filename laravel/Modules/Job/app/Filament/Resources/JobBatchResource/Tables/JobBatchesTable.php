<?php

declare(strict_types=1);

namespace Modules\Job\Filament\Resources\JobBatchResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

/**
 * JobBatchesTable Schema.
 */
class JobBatchesTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'total_jobs' => TextColumn::make('total_jobs')->sortable(),
            'pending_jobs' => TextColumn::make('pending_jobs')->sortable(),
            'failed_jobs' => TextColumn::make('failed_jobs')->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
        ];
    }
}
