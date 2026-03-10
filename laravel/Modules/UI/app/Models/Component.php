<?php

declare(strict_types=1);

namespace Modules\UI\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\UI\Database\Factories\ComponentFactory;

/**
 * Component model for UI module.
 *
 * @property string      $id
 * @property string      $name
 * @property string      $theme_id
 * @property bool        $is_active
 * @property string|null $version
 * @property array|null  $dependencies
 * @property string|null $template
 * @property bool        $is_cacheable
 * @property int|null    $cache_ttl
 * @property array|null  $validation_rules
 * @property string|null $view_path
 * @property array|null  $data_schema
 * @property array|null  $responsive_breakpoints
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Theme       $theme
 * @method static ComponentFactory          factory($count = null, $state = [])
 * @method static Builder<static>|Component newModelQuery()
 * @method static Builder<static>|Component newQuery()
 * @method static Builder<static>|Component query()
 * @property-read \Modules\Ptv\Models\Profile|null $creator
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @property-read \Modules\Ptv\Models\Profile|null $updater
 * @property string|null $type
 * @property string|null $config
 * @property bool $supports_lazy_loading
 * @property float|null $lazy_loading_threshold
 * @property string|null $cache_strategy
 * @property int|null $cache_duration
 * @property string|null $updated_by
 * @property string|null $created_by
 * @method static Builder<static>|Component whereCacheDuration($value)
 * @method static Builder<static>|Component whereCacheStrategy($value)
 * @method static Builder<static>|Component whereCacheTtl($value)
 * @method static Builder<static>|Component whereConfig($value)
 * @method static Builder<static>|Component whereCreatedAt($value)
 * @method static Builder<static>|Component whereCreatedBy($value)
 * @method static Builder<static>|Component whereDataSchema($value)
 * @method static Builder<static>|Component whereDependencies($value)
 * @method static Builder<static>|Component whereId($value)
 * @method static Builder<static>|Component whereIsActive($value)
 * @method static Builder<static>|Component whereIsCacheable($value)
 * @method static Builder<static>|Component whereLazyLoadingThreshold($value)
 * @method static Builder<static>|Component whereName($value)
 * @method static Builder<static>|Component whereResponsiveBreakpoints($value)
 * @method static Builder<static>|Component whereSupportsLazyLoading($value)
 * @method static Builder<static>|Component whereTemplate($value)
 * @method static Builder<static>|Component whereThemeId($value)
 * @method static Builder<static>|Component whereType($value)
 * @method static Builder<static>|Component whereUpdatedAt($value)
 * @method static Builder<static>|Component whereUpdatedBy($value)
 * @method static Builder<static>|Component whereValidationRules($value)
 * @method static Builder<static>|Component whereVersion($value)
 * @method static Builder<static>|Component whereViewPath($value)
 * @mixin \Eloquent
 */
class Component extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'name',
        'theme_id',
        'is_active',
        'version',
        'dependencies',
        'template',
        'is_cacheable',
        'cache_ttl',
        'validation_rules',
        'view_path',
        'data_schema',
        'responsive_breakpoints',
        'supports_lazy_loading',
        'lazy_loading_threshold',
        'cache_strategy',
        'cache_duration',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_cacheable' => 'boolean',
            'dependencies' => 'array',
            'validation_rules' => 'array',
            'data_schema' => 'array',
            'responsive_breakpoints' => 'array',
            'supports_lazy_loading' => 'boolean',
            'lazy_loading_threshold' => 'float',
            'cache_ttl' => 'integer',
            'cache_duration' => 'integer',
        ];
    }

    /**
     * Get the theme that owns the component.
     */
    public function theme(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }
}
