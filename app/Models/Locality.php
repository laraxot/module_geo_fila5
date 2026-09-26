<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\File;
<<<<<<< .merge_file_Xa6ZwM
=======
use Modules\Geo\Database\Factories\LocalityFactory;
>>>>>>> .merge_file_lGKADv
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Contracts\ProfileContract;
use Sushi\Sushi;

/**
 * @property int|null                     $region_id
 * @property int|null                     $province_id
<<<<<<< .merge_file_Xa6ZwM
 * @property int                          $id
 * @property string|null                  $name
=======
 * @property string|null                  $name
 * @property int                          $id
>>>>>>> .merge_file_lGKADv
 * @property array<array-key, mixed>|null $postal_code
 * @property ProfileContract|null         $creator
 * @property ProfileContract|null         $updater
 *
 * @method static Builder<static>|Locality newModelQuery()
 * @method static Builder<static>|Locality newQuery()
 * @method static Builder<static>|Locality query()
 * @method static Builder<static>|Locality whereId($value)
 * @method static Builder<static>|Locality whereName($value)
 * @method static Builder<static>|Locality wherePostalCode($value)
 * @method static Builder<static>|Locality whereProvinceId($value)
 * @method static Builder<static>|Locality whereRegionId($value)
 *
<<<<<<< .merge_file_Xa6ZwM
=======
 * @property ProfileContract|null $deleter
 *
 * @method static LocalityFactory factory($count = null, $state = [])
 *
>>>>>>> .merge_file_lGKADv
 * @mixin \Eloquent
 */
class Locality extends BaseModel
{
    use Sushi;

    /** @var array<string, string> */
    protected array $schema = [
        'region_id' => 'integer',
        'province_id' => 'integer',
        'id' => 'integer',
        'name' => 'string',
        'postal_code' => 'json',
    ];

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

        /** @var array<string, array{region_id: mixed, province_id: mixed, id: mixed, name: string, postal_code: mixed}> $unique */
        $unique = [];

        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }

            $regione = $item['regione'] ?? null;
            $provincia = $item['provincia'] ?? null;
            if (! is_array($regione) || ! is_array($provincia)) {
                continue;
            }

            $regionId = $regione['codice'] ?? null;
            $provinceId = $provincia['codice'] ?? null;
            $id = $item['codice'] ?? $item['id'] ?? null;
            $name = $item['nome'] ?? null;
            if (null === $regionId || null === $provinceId || null === $id || null === $name) {
                continue;
            }

            $key = SafeStringCastAction::cast($id);
            if (! isset($unique[$key])) {
                $unique[$key] = [
                    'region_id' => $regionId,
                    'province_id' => $provinceId,
                    'id' => $id,
                    'name' => SafeStringCastAction::cast($name),
                    'postal_code' => $item['cap'] ?? null,
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
     * @return array<string, string>
     */
    public static function getOptions(Get $get): array
    {
        $region = $get('administrative_area_level_1') ?? $get('region');
        if (! $region) {
            return [];
        }
        $province = $get('administrative_area_level_2') ?? $get('province');
        if (! $province) {
            return [];
        }

        $city = $get('locality');

        $keys = [];
        $values = [];

        foreach (
            self::where('region_id', $region)
                ->where('province_id', $province)
                ->get() as $item
        ) {
            $keys[] = SafeStringCastAction::cast($item->id);
            $values[] = SafeStringCastAction::cast($item->name ?? '');
        }

        return array_combine($keys, $values) ?: [];
    }

    /**
     * @return array<string, string>
     */
    public static function getPostalCodeOptions(Get $get): array
    {
        $region = $get('administrative_area_level_1') ?? $get('region');
        if (! $region) {
            return [];
        }
        $province = $get('administrative_area_level_2') ?? $get('province');
        if (! $province) {
            return [];
        }

        $city = $get('locality');
        $res = self::where('region_id', $region)
            ->where('province_id', $province)
<<<<<<< .merge_file_Xa6ZwM
            ->when(null !== $city, static fn (Builder $query) => $query->where('id', $city))
=======
            ->when(null !== $city, static fn ($query) => $query->where('id', $city))
>>>>>>> .merge_file_lGKADv
            ->select('postal_code')
            ->distinct()
            ->orderBy('postal_code')
            ->get(); // ->pluck('postal_code', 'postal_code')
        // ->toArray()
        /** @var array<string, string> $options */
        $options = [];

        foreach ($res as $item) {
            $postalCode = $item->postal_code ?? null;
            if (! \is_array($postalCode)) {
                continue;
            }

            foreach ($postalCode as $code) {
                if (\is_string($code) || is_numeric($code)) {
                    $codeString = SafeStringCastAction::cast($code);
                    $options[$codeString] = $codeString;
                }
            }
        }

        return $options;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
<<<<<<< .merge_file_Xa6ZwM
=======
    #[\Override]
>>>>>>> .merge_file_lGKADv
    protected function casts(): array
    {
        return [
            'region_id' => 'integer',
            'province_id' => 'integer',
            'id' => 'integer',
            'name' => 'string',
            'postal_code' => 'array',
        ];
    }
}
