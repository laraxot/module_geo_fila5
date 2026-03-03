<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

/**
 * Model representing the available tables for Sigma sync.
 *
 * @property int $id
 * @property string $tbl
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @method static \Modules\Sigma\Database\Factories\TableListFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TableList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TableList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TableList query()
 * @mixin \Eloquent
 */
class TableList extends BaseModel
{
    /** @var list<string> */
    protected $fillable = ['tbl'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'table_list';
}
