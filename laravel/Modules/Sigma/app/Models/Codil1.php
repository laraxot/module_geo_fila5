<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Codil1.
 *
 * @property int $id
 * @property string|null $tipo
 * @property string|null $codice
 * @property string|null $descr
 * @method static Builder|Codil1 newModelQuery()
 * @method static Builder|Codil1 newQuery()
 * @method static Builder|Codil1 query()
 * @method static Builder|Codil1 whereCodice($value)
 * @method static Builder|Codil1 whereDescr($value)
 * @method static Builder|Codil1 whereId($value)
 * @method static Builder|Codil1 whereTipo($value)
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @method static \Modules\Sigma\Database\Factories\Codil1Factory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Codil1 extends BaseModel
{
    protected $table = 'codil1';
}
