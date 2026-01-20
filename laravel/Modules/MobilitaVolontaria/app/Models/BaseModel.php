<?php

declare(strict_types=1);

namespace Modules\MobilitaVolontaria\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
// ---------- traits
use Modules\Xot\Models\Traits\HasXotFactory;
// //use Laravel\Scout\Searchable;
use Modules\Xot\Traits\Updater;

// use Modules\Xot\Services\FactoryService;

/**
 * Class BaseModel.
 */
abstract class BaseModel extends Model
{
    use HasXotFactory;

    // use Searchable;
    // use Cachable;
    use Updater;

    protected $connection = 'mobilita_volontaria'; // this will use the specified database connection

    /**
     * @var list<string>
     */
    protected $fillable = ['id'];

    /**
     * Get the attributes that should be cast.
     *
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
