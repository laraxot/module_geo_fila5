<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Columns;

use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\GroupColumn;

/** @phpstan-ignore-next-line - GroupColumn is final but needs to be extended for this use case */
class PeriodoColumn extends GroupColumn
{
    protected array $extraColumns = [];

    public static function make(?string $name = null): static
    {
        // @phpstan-ignore-next-line
        return parent::make($name)
            ->schema([
                TextColumn::make('dal'),
                TextColumn::make('al'),
                TextColumn::make('anno'),
            ]);
    }

    public function appendColumns(array<string, mixed> $columns): static
    {
        $this->extraColumns = array_merge($this->extraColumns, $columns);

        $form = array_merge(
            $this->getSchema(),
            $this->extraColumns
        );

        // @phpstan-ignore-next-line
        return $this->schema($form);
    }

    protected function getSchema(): array
    {
        return [
            TextColumn::make('dal'),
            TextColumn::make('al'),
            TextColumn::make('anno'),
        ];
    }
}
