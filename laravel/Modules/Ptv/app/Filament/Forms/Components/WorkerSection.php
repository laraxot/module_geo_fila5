<?php

declare(strict_types=1);

/*
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\Ptv\Filament\Forms\Components;

use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class WorkerSection extends Section
{
    public static function getDefaultName(): ?string
    {
        return 'worker';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            Grid::make(4)->schema([
                TextInput::make('matr'),
                TextInput::make('cognome'),
                TextInput::make('nome'),
                TextInput::make('email'),

            ]),
        ]);
    }
}
