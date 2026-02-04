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

class PeriodoSection extends Section
{
   public array $add=[];

    public static function getDefaultName(): ?string
    {
        return 'PeriodoSection';
    }

    public function add(array $array):self{
        $this->add=array_merge($this->add,$array);
        return $this;
    }

    public function getSchema():array{
        $schema=[
                'dal'=>TextInput::make('dal'),
                'al'=>TextInput::make('al'),
                'anno'=>TextInput::make('anno'),
                ...$this->add,
        ];
        
        return $schema;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema(fn()=>[
            Grid::make(4)->schema($this->getSchema()),
        ]);
    }
}
