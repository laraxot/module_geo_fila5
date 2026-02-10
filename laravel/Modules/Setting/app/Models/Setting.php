<?php

declare(strict_types=1);

namespace Modules\Setting\Models;

use Closure;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Carbon;
use Modules\Media\Models\Media;
use Modules\Setting\Database\Factories\SettingFactory;
use Modules\Xot\Contracts\ProfileContract;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;

/**
 * @property int                         $id
 * @property string                      $group
 * @property string                      $name
 * @property int                         $locked
 * @property string                      $payload
 * @property Carbon|null                 $created_at
 * @property Carbon|null                 $updated_at
 * @property MediaCollection<int, Media> $media
 * @property int|null                    $media_count
 * @method static SettingFactory  factory($count = null, $state = [])
 * @method static Builder|Setting newModelQuery()
 * @method static Builder|Setting newQuery()
 * @method static Builder|Setting query()
 * @method static Builder|Setting whereCreatedAt($value)
 * @method static Builder|Setting whereGroup($value)
 * @method static Builder|Setting whereId($value)
 * @method static Builder|Setting whereLocked($value)
 * @method static Builder|Setting whereName($value)
 * @method static Builder|Setting wherePayload($value)
 * @method static Builder|Setting whereUpdatedAt($value)
 * @property ProfileContract|null $creator
 * @property ProfileContract|null $updater
 * @method static Setting|null             first()
 * @method static Collection<int, Setting> get()
 * @method static Setting                  create(array $attributes = [])
 * @method static Setting                  firstOrCreate(array $attributes = [], array $values = [])
 * @method static Builder<static>|Setting  where((string|Closure) $column, mixed $operator = null, mixed $value = null, string $boolean = 'and')
 * @method static Builder<static>|Setting  whereNotNull((string|Expression) $columns)
 * @method static int                      count(string $columns = '*')
 * @property-read \Modules\Ptv\Models\Profile|null $deleter
 * @mixin \Eloquent
 */
class Setting extends BaseModel implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [''];

    // use HasUuids;
}
