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
 * @method static Builder newModelQuery()
 * @method static Builder newQuery()
 * @method static Builder query()
 * @method static Builder whereAnno($value)
 * @method static Builder whereBudget($value)
 * @method static Builder whereCreatedAt($value)
 * @method static Builder whereCreatedBy($value)
 * @method static Builder whereEnte($value)
 * @method static Builder whereId($value)
 * @method static Builder whereMatr($value)
 * @method static Builder whereNomeDiri($value)
 * @method static Builder whereNomeDiriPlus($value)
 * @method static Builder whereNomeStabi($value)
 * @method static Builder wherePostId($value)
 * @method static Builder wherePostType($value)
 * @method static Builder whereRepar($value)
 * @method static Builder whereStabi($value)
 * @method static Builder whereUpdatedAt($value)
 * @method static Builder whereUpdatedBy($value)
 * @method static Builder whereValutatoreId($value)
 */
interface StabiDirigenteContract
{
    public function schede(): HasMany;
}
