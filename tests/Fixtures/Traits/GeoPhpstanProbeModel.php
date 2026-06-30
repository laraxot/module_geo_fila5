<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Modules\Geo\Models\BaseModel;

/**
 * @property int|string|null $id
<<<<<<< HEAD
 * @property mixed|null      $address
=======
 * @property mixed|null $address
>>>>>>> e3f0965 (.)
 */
abstract class GeoPhpstanProbeModel extends BaseModel
{
    protected $table = 'geo_phpstan_trait_probes';
}
