<?php

declare(strict_types=1);

namespace Modules\UI\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\UI\Database\Factories\AssetFactory;

/**
 * Asset model for UI module.
 *
 * @property string      $id
 * @property string      $name
 * @property string      $type
 * @property string      $path
 * @property string      $theme_id
 * @property bool        $is_minified
 * @property bool        $is_compressed
 * @property int         $order
 * @property bool        $should_bundle
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Theme       $theme
 * @method static AssetFactory          factory($count = null, $state = [])
 * @method static Builder<static>|Asset newModelQuery()
 * @method static Builder<static>|Asset newQuery()
 * @method static Builder<static>|Asset query()
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @property string $disk
 * @property string|null $extension
 * @property int|null $size
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static Builder<static>|Asset whereCreatedAt($value)
 * @method static Builder<static>|Asset whereCreatedBy($value)
 * @method static Builder<static>|Asset whereDisk($value)
 * @method static Builder<static>|Asset whereExtension($value)
 * @method static Builder<static>|Asset whereId($value)
 * @method static Builder<static>|Asset whereIsCompressed($value)
 * @method static Builder<static>|Asset whereIsMinified($value)
 * @method static Builder<static>|Asset whereName($value)
 * @method static Builder<static>|Asset whereOrder($value)
 * @method static Builder<static>|Asset wherePath($value)
 * @method static Builder<static>|Asset whereShouldBundle($value)
 * @method static Builder<static>|Asset whereSize($value)
 * @method static Builder<static>|Asset whereThemeId($value)
 * @method static Builder<static>|Asset whereType($value)
 * @method static Builder<static>|Asset whereUpdatedAt($value)
 * @method static Builder<static>|Asset whereUpdatedBy($value)
 * @mixin \Eloquent
 */
class Asset extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'name',
        'type',
        'path',
        'theme_id',
        'is_minified',
        'is_compressed',
        'order',
        'should_bundle',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_minified' => 'boolean',
            'is_compressed' => 'boolean',
            'should_bundle' => 'boolean',
            'order' => 'integer',
        ];
    }

    /**
     * Get the theme that owns the asset.
     */
    public function theme(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }
}
