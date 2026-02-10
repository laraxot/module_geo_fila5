<?php

declare(strict_types=1);

namespace Modules\Ptv\Models;

// --- TRAITS ---
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Modules\Ptv\Database\Factories\HomeFactory;
use Modules\Xot\Models\Traits\WidgetTrait;
use Sushi\Sushi;

// ------ ext models---
/**
 * Modules\Ptv\Models\Home.
 *
 * @property int|null $id
 * @property string|null $name
 * @property string|null $icon_src
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Collection $containerWidgets
 * @property int|null $container_widgets_count
 * @property Collection $widgets
 * @property int|null $widgets_count
 *
 * @method static HomeFactory factory($count = null, $state = [])
 * @method static Builder|Home newModelQuery()
 * @method static Builder|Home newQuery()
 * @method static Builder|Home ofLayoutPosition($layout_position)
 * @method static Builder|Home query()
 * @method static Builder|Home whereCreatedBy($value)
 * @method static Builder|Home whereIconSrc($value)
 * @method static Builder|Home whereId($value)
 * @method static Builder|Home whereName($value)
 * @method static Builder|Home whereUpdatedBy($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 */
class Home extends BaseModel
{
    use Sushi;

    // use WidgetTrait;

    /** @return  array<int, string> */
    protected $fillable = ['id', 'icon_src'];

    /**
     * Undocumented variable.
     *
     * @var array
     */
    protected $rows = [
        [
            'id' => 'home',
            'name' => 'New York',
            'icon_src' => '',
            'created_by' => 'xot',
            'updated_by' => 'xot',
        ],
    ];
}
