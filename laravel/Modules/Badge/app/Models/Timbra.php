<?php

declare(strict_types=1);

namespace Modules\Badge\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Badge\Database\Factories\TimbraFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Badge\Models\Timbra.
 *
 * @method static TimbraFactory factory($count = null, $state = [])
 * @method static Builder|Timbra newModelQuery()
 * @method static Builder|Timbra newQuery()
 * @method static Builder|Timbra query()
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property int $id
 * @property string|null $field0
 * @property string|null $field1
 * @property string|null $field2
 * @property string|null $field3
 * @property string|null $field4
 * @property string|null $field5
 * @property string|null $field6
 * @property string|null $field7
 * @property string|null $field8
 * @property string|null $field9
 * @property string|null $field10
 * @property string|null $field11
 * @property string|null $field12
 * @property string|null $field13
 * @property string|null $field14
 * @property string|null $field15
 * @property string|null $field16
 * @property string|null $field17
 * @property string|null $field18
 * @property string|null $field19
 * @property string|null $field20
 * @property string|null $field21
 * @property string|null $field22
 * @property string|null $field23
 * @property string|null $field24
 * @property string|null $field25
 * @property string|null $field26
 * @property string|null $field27
 * @property string|null $field28
 * @property string|null $field29
 * @property string|null $field30
 * @property string|null $field31
 * @property string|null $field32
 * @property string|null $field33
 * @property string|null $field34
 * @property string|null $field35
 * @property string|null $field36
 * @property string|null $field37
 * @property string|null $field38
 * @property string|null $field39
 * @property string|null $field40
 * @property string|null $field41
 * @property string|null $field42
 * @property string|null $field43
 * @property string|null $field44
 * @property string|null $field45
 * @property string|null $field46
 * @property string|null $field47
 * @property string|null $field48
 * @property string|null $field49
 * @property string|null $field50
 * @property string|null $field51
 * @property string|null $field52
 * @property string|null $field53
 * @property string|null $field54
 * @property-read Profile|null $deleter
 * @method static Builder<static>|Timbra whereField0($value)
 * @method static Builder<static>|Timbra whereField1($value)
 * @method static Builder<static>|Timbra whereField10($value)
 * @method static Builder<static>|Timbra whereField11($value)
 * @method static Builder<static>|Timbra whereField12($value)
 * @method static Builder<static>|Timbra whereField13($value)
 * @method static Builder<static>|Timbra whereField14($value)
 * @method static Builder<static>|Timbra whereField15($value)
 * @method static Builder<static>|Timbra whereField16($value)
 * @method static Builder<static>|Timbra whereField17($value)
 * @method static Builder<static>|Timbra whereField18($value)
 * @method static Builder<static>|Timbra whereField19($value)
 * @method static Builder<static>|Timbra whereField2($value)
 * @method static Builder<static>|Timbra whereField20($value)
 * @method static Builder<static>|Timbra whereField21($value)
 * @method static Builder<static>|Timbra whereField22($value)
 * @method static Builder<static>|Timbra whereField23($value)
 * @method static Builder<static>|Timbra whereField24($value)
 * @method static Builder<static>|Timbra whereField25($value)
 * @method static Builder<static>|Timbra whereField26($value)
 * @method static Builder<static>|Timbra whereField27($value)
 * @method static Builder<static>|Timbra whereField28($value)
 * @method static Builder<static>|Timbra whereField29($value)
 * @method static Builder<static>|Timbra whereField3($value)
 * @method static Builder<static>|Timbra whereField30($value)
 * @method static Builder<static>|Timbra whereField31($value)
 * @method static Builder<static>|Timbra whereField32($value)
 * @method static Builder<static>|Timbra whereField33($value)
 * @method static Builder<static>|Timbra whereField34($value)
 * @method static Builder<static>|Timbra whereField35($value)
 * @method static Builder<static>|Timbra whereField36($value)
 * @method static Builder<static>|Timbra whereField37($value)
 * @method static Builder<static>|Timbra whereField38($value)
 * @method static Builder<static>|Timbra whereField39($value)
 * @method static Builder<static>|Timbra whereField4($value)
 * @method static Builder<static>|Timbra whereField40($value)
 * @method static Builder<static>|Timbra whereField41($value)
 * @method static Builder<static>|Timbra whereField42($value)
 * @method static Builder<static>|Timbra whereField43($value)
 * @method static Builder<static>|Timbra whereField44($value)
 * @method static Builder<static>|Timbra whereField45($value)
 * @method static Builder<static>|Timbra whereField46($value)
 * @method static Builder<static>|Timbra whereField47($value)
 * @method static Builder<static>|Timbra whereField48($value)
 * @method static Builder<static>|Timbra whereField49($value)
 * @method static Builder<static>|Timbra whereField5($value)
 * @method static Builder<static>|Timbra whereField50($value)
 * @method static Builder<static>|Timbra whereField51($value)
 * @method static Builder<static>|Timbra whereField52($value)
 * @method static Builder<static>|Timbra whereField53($value)
 * @method static Builder<static>|Timbra whereField54($value)
 * @method static Builder<static>|Timbra whereField6($value)
 * @method static Builder<static>|Timbra whereField7($value)
 * @method static Builder<static>|Timbra whereField8($value)
 * @method static Builder<static>|Timbra whereField9($value)
 * @method static Builder<static>|Timbra whereId($value)
 * @mixin \Eloquent
 */
class Timbra extends BaseModel
{
    protected $fillable = ['id', 'field0', 'field1', 'field2', 'field3', 'field4', 'field5', 'field6', 'field7', 'field8', 'field9', 'field10', 'field11', 'field12', 'field13', 'field14', 'field15', 'field16', 'field17', 'field18', 'field19', 'field20', 'field21', 'field22', 'field23', 'field24', 'field25', 'field26', 'field27', 'field28', 'field29', 'field30', 'field31', 'field32', 'field33', 'field34', 'field35', 'field36', 'field37', 'field38', 'field39', 'field40', 'field41', 'field42', 'field43', 'field44', 'field45', 'field46', 'field47', 'field48', 'field49', 'field50', 'field51', 'field52', 'field53', 'field54'];
}
