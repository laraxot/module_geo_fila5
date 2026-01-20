<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Modules\IndennitaResponsabilita\Database\Factories\RatingFactory;
use Modules\Media\Models\Media;
use Modules\Ptv\Models\Profile;
use Modules\Rating\Enums\RuleEnum;
use Modules\Rating\Models\Rating as BaseRatingModel;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\SchemalessAttributes\SchemalessAttributes;

/**
 * Modules\IndennitaResponsabilita\Models\Rating
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $color
 * @property string|null $icon
 * @property string|null $txt
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property SchemalessAttributes|null $extra_attributes
 * @property RuleEnum|null $rule
 * @property bool|null $is_disabled
 * @property bool|null $is_readonly
 * @property int|null $order_column
 *
 * @method static Builder|Rating newModelQuery()
 * @method static Builder|Rating newQuery()
 * @method static Builder|Rating query()
 * @method static Builder|Rating whereColor($value)
 * @method static Builder|Rating whereCreatedAt($value)
 * @method static Builder|Rating whereCreatedBy($value)
 * @method static Builder|Rating whereExtraAttributes($value)
 * @method static Builder|Rating whereIcon($value)
 * @method static Builder|Rating whereId($value)
 * @method static Builder|Rating whereIsDisabled($value)
 * @method static Builder|Rating whereIsReadonly($value)
 * @method static Builder|Rating whereOrderColumn($value)
 * @method static Builder|Rating whereRule($value)
 * @method static Builder|Rating whereTitle($value)
 * @method static Builder|Rating whereTxt($value)
 * @method static Builder|Rating whereUpdatedAt($value)
 * @method static Builder|Rating whereUpdatedBy($value)
 * @method static Builder|Rating withExtraAttributes(string|array $schemalessAttributes = [], mixed $value = null)
 *
 * @property-read Profile|null $creator
 * @property-read Model|\Eloquent $linkedTo
 * @property-read MediaCollection<int, Media> $media
 * @property-read int|null $media_count
 * @property-read Profile|null $updater
 *
 * @method static RatingFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Rating extends BaseRatingModel
{
    protected $connection = 'indennita_responsabilita'; // this will use the specified database connection

    // -------------------------------------------------
}
