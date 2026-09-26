<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Spatie\LaravelData\Data;

class GeoData extends Data
{
<<<<<<< .merge_file_aRwQsY
    /** @var array{lat?: float|int|string, lng?: float|int|string} */
=======
    /** @var array<mixed> */
>>>>>>> .merge_file_JXf5yt
    public array $latlng;

    public string $route;

    public string $street_number;

    public string $postal_code;

    public string $administrative_area_level_3;

    public string $administrative_area_level_2_short;

    public string $value;
}
