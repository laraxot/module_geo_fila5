<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Modules\User\Contracts\TeamInvitationContract.
 *
 * @property int          $id
 * @property int          $team_id
 * @property string       $email
 * @property string|null  $role
 * @property Carbon|null  $created_at
 * @property Carbon|null  $updated_at
 * @property TeamContract $team
 *
 * @method static Builder<Model> newModelQuery()
 * @method static Builder<Model> newQuery()
 * @method static Builder<Model> query()
 * @method static Builder<Model> whereCreatedAt($value)
 * @method static Builder<Model> whereEmail($value)
 * @method static Builder<Model> whereId($value)
 * @method static Builder<Model> whereRole($value)
 * @method static Builder<Model> whereTeamId($value)
 * @method static Builder<Model> whereUpdatedAt($value)
 *
 * @phpstan-require-extends Model
 *
 * @mixin \Eloquent
 */
interface TeamInvitationContract
{
    public function delete(): void;
}
