<?php

declare(strict_types=1);

namespace Modules\Progressioni\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class CedDiffImport implements ToCollection
{
    protected array $columns = [];

    /**
 * @param \Illuminate\Support\Collection<int, array> $rows
 */
        public function collection(Collection $rows): void
    {
        $firstRow = $rows->first();
        if ($firstRow instanceof Collection || is_array($firstRow)) {
            $this->columns = is_array($firstRow) ? $firstRow : $firstRow->toArray();
        } else {
            $this->columns = [];
        }
    }

    /** @return array<mixed> */
        public function getColumns(): array
    {
        $res = array_map(function ($column) {
            /** @var string $column */
            $name = Str::of((string) $column)->slug('_')->toString();

            return [
                'name' => $name,
                'type' => 'string',
            ];
        }, $this->columns);

        return $res;
    }
}
