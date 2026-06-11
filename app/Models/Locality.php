<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Database\Eloquent\Builder;
use Modules\Geo\Database\Factories\LocalityFactory;
use Modules\Xot\Contracts\ProfileContract;
use Sushi\Sushi;

/**
 * @property int|null                     $region_id
 * @property int|null                     $province_id
 * @property string|null                  $name
 * @property int                          $id
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
 * @property ProfileContract|null $deleter
 *
 * @method static LocalityFactory factory($count = null, $state = [])
 *
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
        $rows = Comune::select(
            'regione->codice as region_id',
            'provincia->codice as province_id',
            'nome as name',
            'codice as id',
            'cap as postal_code',
        )
            ->distinct()
            ->orderBy('nome')
            ->get();

        return $rows
            ->map(static fn (Comune $row): array => $row->attributesToArray())
            ->values()
            ->all();
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
            $keys[] = (string) $item->id;
            $values[] = (string) ($item->name ?? '');
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
            ->when(null !== $city, static fn ($query) => $query->where('id', $city))
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
                    $codeString = (string) $code;
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
    #[\Override]
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
