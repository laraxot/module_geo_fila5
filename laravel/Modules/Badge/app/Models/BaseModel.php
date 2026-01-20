<?php

declare(strict_types=1);

namespace Modules\Badge\Models;

use Modules\Xot\Models\XotBaseModel;

// ---------- traits
// //use Laravel\Scout\Searchable;

/**
 * Class BaseModel.
 */
abstract class BaseModel extends XotBaseModel
{
    protected $connection = 'badge';

    /**
     * @var list<string>
     */
    protected $fillable = ['id'];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /** @var string */
    protected $primaryKey = 'id';

    /** @var bool */
    public $incrementing = true;

    /**
     * @var list<string>
     */
    protected $hidden = [
        // 'password'
    ];

    /** @var bool */
    public $timestamps = true;
}
