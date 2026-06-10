<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Geo\Database\Factories\RegionFactory;
use Modules\Xot\Contracts\ProfileContract;
use Modules\Xot\Models\Traits\HasXotFactory;
use Sushi\Sushi;

/**
 * @property int                       $id
 * @property string|null               $name
 * @property ProfileContract|null      $creator
 * @property Collection<int, Province> $provinces
 * @property int|null                  $provinces_count
 * @property ProfileContract|null      $updater
 *
 * @method static RegionFactory          factory($count = null, $state = [])
 * @method static Builder<static>|Region newModelQuery()
 * @method static Builder<static>|Region newQuery()
 * @method static Builder<static>|Region query()
 * @method static Builder<static>|Region whereId($value)
 * @method static Builder<static>|Region whereName($value)
 *
 * @property ProfileContract|null $deleter
 *
 * @mixin \Eloquent
 */
class Region extends BaseModel
{
    /** @phpstan-use HasXotFactory<\Modules\Geo\Database\Factories\RegionFactory> */
    use HasXotFactory;
    use Sushi;

    /**
     * The data type of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /** @var array<string, string> */
    protected array $schema = [
        'id' => 'integer',
        'name' => 'string',
    ];

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        $rows = Comune::select('regione->codice as id', 'regione->nome as name')
            ->distinct()
            ->orderBy('regione->nome')
            ->get();

        return $rows
            ->map(static fn (Comune $row): array => $row->attributesToArray())
            ->values()
            ->all();
    }

    /**
     * @return HasMany<Province, $this>
     */
    public function provinces(): HasMany
    {
        return $this->hasMany(Province::class);
    }

    /**
     * @return array<string, string>
     */
    public static function getOptions(Get $get): array
    {
        $keys = [];
        $values = [];

        foreach (self::orderBy('name')->get() as $item) {
            $keys[] = (string) $item->id;
            $values[] = (string) ($item->name ?? '');
        }

        return array_combine($keys, $values) ?: [];
    }
}
