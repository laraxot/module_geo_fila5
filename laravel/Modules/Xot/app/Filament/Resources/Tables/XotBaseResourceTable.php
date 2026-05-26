<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\Tables;

<<<<<<< HEAD
use Filament\Tables\Table;
use Modules\Xot\Filament\Traits\HasXotTable;
=======
use Filament\Tables\Columns\Column;
>>>>>>> 93fecd1d (.)

abstract class XotBaseResourceTable
{
    use HasXotTable;

    public static function configure(Table $table): Table
    {
        return $this->table($table);
    }

    /**
     * @return array<int|string, Column>
     */
    abstract public function getTableColumns(): array;
}
