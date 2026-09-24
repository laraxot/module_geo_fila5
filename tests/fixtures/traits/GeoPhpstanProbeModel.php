<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Modules\Geo\Models\BaseModel;

/**
 * <<<<<<< .merge_file_PQZ1RX
 * =======
 * PHPStan probe model for Geo trait tests.
 *
 * >>>>>>> .merge_file_5rFqn9
 *
 * @property int|string|null $id
 * @property mixed|null      $address
 */
abstract class GeoPhpstanProbeModel extends BaseModel
{
    protected $table = 'geo_phpstan_trait_probes';
}
