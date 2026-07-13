<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\File;
use Modules\Geo\Database\Factories\RegionFactory;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
=======
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Geo\Database\Factories\RegionFactory;
>>>>>>> laraxot/dev
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
<<<<<<< HEAD
    /** @phpstan-use HasXotFactory<\Modules\Geo\Database\Factories\RegionFactory> */
=======
    /** @use HasXotFactory<\Illuminate\Database\Eloquent\Factories\Factory<static>> */
>>>>>>> laraxot/dev
    use HasXotFactory;
    use Sushi;

    /**
<<<<<<< HEAD
     * The data type of the primary key ID.
     *
     * @var string
=======
     * The factory class for this model.
     *
     * @var class-string<Factory<Region>>
     */
    protected static $factory = RegionFactory::class;

    /**
     * The data type of the primary key ID.
>>>>>>> laraxot/dev
     */
    protected $keyType = 'integer';

    /** @var array<string, string> */
    protected array $schema = [
        'id' => 'integer',
        'name' => 'string',
    ];

<<<<<<< HEAD
    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        $path = module_path('Geo', 'resources/json/comuni.json');
        if (! file_exists($path)) {
            return [];
        }

        $items = File::json($path);
        if (! is_array($items)) {
            return [];
        }

        /** @var array<string, array{id: mixed, name: string}> $unique */
        $unique = [];

        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $regione = $item['regione'] ?? null;
            if (is_string($regione)) {
                $id = $regione;
                $name = $regione;
            } elseif (is_array($regione)) {
                $id = $regione['codice'] ?? null;
                $name = $regione['nome'] ?? null;
            } else {
                continue;
            }

            if (null === $id || null === $name) {
                continue;
            }

            $key = SafeStringCastAction::cast($id);
            if (! isset($unique[$key])) {
                $unique[$key] = [
                    'id' => $id,
                    'name' => SafeStringCastAction::cast($name),
                ];
            }
        }

        $rows = array_values($unique);
        usort(
            $rows,
            static fn (array $a, array $b): int => strcmp(
                SafeStringCastAction::cast($a['name'] ?? ''),
                SafeStringCastAction::cast($b['name'] ?? ''),
            ),
        );

        return $rows;
    }

    /**
     * @return HasMany<Province, $this>
     */
=======
    /** @return array<mixed> */
    public function getRows(): array
    {
        $rows = Comune::select('regione->codice as id', 'regione->nome as name')
            ->distinct()
            ->orderBy('regione->nome')
            ->get();

        return $rows->toArray();
    }

    /** @return HasMany<Province, $this> */
>>>>>>> laraxot/dev
    public function provinces(): HasMany
    {
        return $this->hasMany(Province::class);
    }

<<<<<<< HEAD
    /**
     * @return array<string, string>
     */
    public static function getOptions(Get $get): array
    {
        $keys = [];
        $values = [];

        foreach (self::orderBy('name')->get() as $item) {
            $keys[] = SafeStringCastAction::cast($item->id);
            $values[] = SafeStringCastAction::cast($item->name ?? '');
        }

        return array_combine($keys, $values) ?: [];
=======
    /** @return array<mixed> */
    public static function getOptions(Get $get): array
    {
        return self::orderBy('name')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
>>>>>>> laraxot/dev
    }
}
