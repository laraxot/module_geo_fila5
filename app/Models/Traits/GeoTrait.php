<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
<<<<<<< .merge_file_7Wu2qy
use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Actions\Distance\CalculateGeoDistanceAction;
use Modules\Xot\Actions\Cast\SafeFloatCastAction;
use Webmozart\Assert\Assert;
=======
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Str;
// --- models ---
use Modules\Geo\Actions\Distance\BuildHaversineSqlAction;
use Modules\Geo\Actions\Distance\CalculateGeoDistanceAction;
use Modules\Geo\Datas\GeoData;
use Modules\Xot\Actions\Cast\SafeFloatCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
>>>>>>> .merge_file_CrbeQc

/**
 * Distanza e scope geografici per modelli con colonne `latitude` / `longitude`.
 *
<<<<<<< .merge_file_7Wu2qy
 * Perché: un solo punto per Haversine su Address (e consumer futuri), senza
 * mutator JSON legacy che collidono con accessor già definiti sui modelli.
 * SQL letterale + binding (come Address::scopeNearby) per tipizzare literal-string.
 *
 * @property float|null $latitude
 * @property float|null $longitude
 *
 * @phpstan-require-extends Model
=======
 * @property float       $latitude
 * @property float       $longitude
 * @property string      $country
 * @property string      $administrative_area_level_2
 * @property string      $administrative_area_level_2_short
 * @property string      $administrative_area_level_3
 * @property string      $locality
 * @property string      $route
 * @property string      $street_number
 * @property string      $postal_code
 * @property string|null $address
>>>>>>> .merge_file_CrbeQc
 */
trait GeoTrait
{
    public function distance(?float $lat = null, ?float $lng = null): ?float
    {
        $distance = app(CalculateGeoDistanceAction::class)->execute(
            SafeFloatCastAction::cast($this->latitude),
            SafeFloatCastAction::cast($this->longitude),
            $lat,
            $lng,
            '',
        );

        return null !== $distance ? SafeFloatCastAction::cast($distance) : null;
    }

    public function distanceCustomField(
        string $lat_field,
        string $lng_field,
        ?float $lat = null,
        ?float $lng = null,
        ?string $unit = '',
    ): ?float {
<<<<<<< .merge_file_7Wu2qy
        Assert::regex($lat_field, '/^[A-Za-z_][A-Za-z0-9_]*$/');
        Assert::regex($lng_field, '/^[A-Za-z_][A-Za-z0-9_]*$/');

        $latFromField = SafeFloatCastAction::cast($this->{$lat_field});
        $lngFromField = SafeFloatCastAction::cast($this->{$lng_field});
=======
        $latFieldValue = $this->{$lat_field};
        $lngFieldValue = $this->{$lng_field};
        $latFromField = SafeFloatCastAction::cast($latFieldValue);
        $lngFromField = SafeFloatCastAction::cast($lngFieldValue);
>>>>>>> .merge_file_CrbeQc

        $distance = app(CalculateGeoDistanceAction::class)->execute(
            $latFromField,
            $lngFromField,
            $lat,
            $lng,
            $unit,
        );

        return null !== $distance ? SafeFloatCastAction::cast($distance) : null;
    }

    /**
     * Ordina per distanza Haversine da un punto (colonna distance in select).
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeWithDistance(Builder $query, float $lat, float $lng): Builder
    {
        if ($lat <= 0 || $lng <= 0) {
            return $query;
        }

        return $query
            ->selectRaw(
                '*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) * 1.1515 AS distance',
                [$lat, $lng, $lat],
            )
            ->orderBy('distance');
    }

    /**
     * Filtra righe il cui poligono JSON (`zone_polygon`) contiene il punto.
     *
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeOfInPolygon(Builder $query, string $polygon_field, float $lat, float $lng): Builder
    {
        Assert::regex($polygon_field, '/^[A-Za-z_][A-Za-z0-9_]*$/');

        return $query
            ->whereNotNull($polygon_field)
            ->whereRaw(
                "ST_Contains(
        ST_GeomFromText(
       concat('POLYGON((',
       REPLACE(
       REPLACE(
       REPLACE(
       REPLACE(
       replace(CONCAT(
       replace(replace(JSON_extract(zone_polygon,'$'),']',''),'[',''),
       ',',JSON_extract(zone_polygon,'$[0]'))
       ,'\"lat\":','')
       ,',\"lng\":',' ')
       ,'{',' ')
       ,', \"lng\":',' ')
       ,'}','')
       ,'))')
       ), ST_GeomFromText(CONCAT('POINT(', ?, ' ', ?, ')')))
       )",
                [$lat, $lng],
            );
    }
}
