<?php

declare(strict_types=1);

namespace Modules\Ptv\Models\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Ptv\Database\Factories\StabiDirigenteFactory;

/**
 * Undocumented interface.
 *
 * @property int $id
 * @property int|null $stabi
 * @property int|null $repar
 * @property string|null $nome_stabi
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $nome_diri
 * @property string|null $nome_diri_plus
 * @property string|null $budget
 * @property int|null $valutatore_id
 * @property int|null $anno
 * @property string|null $post_type
 * @property int|null $post_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property mixed $repart
 *
 * @method static StabiDirigenteFactory factory(...$parameters)
 * @method static Builder<static> newModelQuery()
 * @method static Builder<static> newQuery()
 * @method static Builder<static> query()
 * @method static Builder<static> whereAnno($value)
 * @method static Builder<static> whereBudget($value)
 * @method static Builder<static> whereCreatedAt($value)
 * @method static Builder<static> whereCreatedBy($value)
 * @method static Builder<static> whereEnte($value)
 * @method static Builder<static> whereId($value)
 * @method static Builder<static> whereMatr($value)
 * @method static Builder<static> whereNomeDiri($value)
 * @method static Builder<static> whereNomeDiriPlus($value)
 * @method static Builder<static> whereNomeStabi($value)
 * @method static Builder<static> wherePostId($value)
 * @method static Builder<static> wherePostType($value)
 * @method static Builder<static> whereRepar($value)
 * @method static Builder<static> whereStabi($value)
 * @method static Builder<static> whereUpdatedAt($value)
 * @method static Builder<static> whereUpdatedBy($value)
 * @method static Builder<static> whereValutatoreId($value)
 */
interface StabiDirigenteContract
{
    public function schede(): HasMany;
}
