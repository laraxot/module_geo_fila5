<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * Modules\Sigma\Models\Acp00l2.
 *
 * @property int $id
 * @property int $ente
 * @property int $matr
 * @property int $acpkvo
 * @property int $acpali
 * @property int $acpmli
 * @property int $acpgio
 * @property int $acpcon
 * @property string $acpope
 * @property string $acptip
 * @property int $acpvoc
 * @property int $acpimp
 * @property string $acpeur
 * @property string $acpann
 *
 * @method static Builder|Acp00l2 newModelQuery()
 * @method static Builder|Acp00l2 newQuery()
 * @method static Builder|Acp00l2 query()
 * @method static Builder|Acp00l2 whereAcpali($value)
 * @method static Builder|Acp00l2 whereAcpann($value)
 * @method static Builder|Acp00l2 whereAcpcon($value)
 * @method static Builder|Acp00l2 whereAcpeur($value)
 * @method static Builder|Acp00l2 whereAcpgio($value)
 * @method static Builder|Acp00l2 whereAcpimp($value)
 * @method static Builder|Acp00l2 whereAcpkvo($value)
 * @method static Builder|Acp00l2 whereAcpmli($value)
 * @method static Builder|Acp00l2 whereAcpope($value)
 * @method static Builder|Acp00l2 whereAcptip($value)
 * @method static Builder|Acp00l2 whereAcpvoc($value)
 * @method static Builder|Acp00l2 whereEnte($value)
 * @method static Builder|Acp00l2 whereId($value)
 * @method static Builder|Acp00l2 whereMatr($value)
 *
 * @mixin \Eloquent
 */
class Acp00l2 extends BaseModel
{
    protected $table = 'acp00l2';
}
