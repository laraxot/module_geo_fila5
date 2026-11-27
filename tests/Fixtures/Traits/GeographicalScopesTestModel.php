<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Illuminate\Database\Eloquent\Model;
<<<<<<< .merge_file_BwgnwL
use Modules\Geo\Models\Traits\GeographicalScopes;

/**
 * Model fixture for the GeographicalScopes contract (scopes costruiti senza toccare il database).
 */
final class GeographicalScopesTestModel extends Model
{
    use GeographicalScopes;
=======
use Modules\Geo\Models\Traits\GeoTrait;

/** Fixture per gli scope distanza di GeoTrait (SQL + binding, senza DB). */
final class GeographicalScopesTestModel extends Model
{
    use GeoTrait;
>>>>>>> .merge_file_XDRrLj

    protected $table = 'places';
}
