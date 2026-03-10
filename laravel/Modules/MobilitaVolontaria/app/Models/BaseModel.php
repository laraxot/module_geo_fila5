<?php

declare(strict_types=1);

namespace Modules\MobilitaVolontaria\Models;

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

    /**
     * Get the current connection name for the model.
     * Returns the module-specific connection if configured, otherwise falls back to default.
     *
     * @return string|null
     */
    public function getConnectionName(): ?string
    {
        $connection = 'mobilita_volontaria';

        // Check if the connection exists in config, otherwise fallback to default
        if (config("database.connections.{$connection}") === null) {
            return config('database.default');
        }

        return $connection;
    }

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
