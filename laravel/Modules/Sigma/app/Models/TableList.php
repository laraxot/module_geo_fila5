<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

/**
 * Model representing the available tables for Sigma sync.
 *
 * @property int $id
 * @property string $tbl
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
