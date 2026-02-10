<?php

declare(strict_types=1);

namespace Modules\Mensa\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Ptv\Models\Profile;
use Modules\Xot\Traits\Updater;

/**
 * Modules\Mensa\Models\Timbra.
 *
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
 * @method static Builder|Timbra newModelQuery()
 * @method static Builder|Timbra newQuery()
 * @method static Builder|Timbra query()
 * @method static Builder|Timbra whereField0($value)
 * @method static Builder|Timbra whereField1($value)
 * @method static Builder|Timbra whereField10($value)
 * @method static Builder|Timbra whereField11($value)
 * @method static Builder|Timbra whereField12($value)
 * @method static Builder|Timbra whereField13($value)
 * @method static Builder|Timbra whereField14($value)
 * @method static Builder|Timbra whereField15($value)
 * @method static Builder|Timbra whereField16($value)
 * @method static Builder|Timbra whereField17($value)
 * @method static Builder|Timbra whereField18($value)
 * @method static Builder|Timbra whereField19($value)
 * @method static Builder|Timbra whereField2($value)
 * @method static Builder|Timbra whereField20($value)
 * @method static Builder|Timbra whereField21($value)
 * @method static Builder|Timbra whereField22($value)
 * @method static Builder|Timbra whereField23($value)
 * @method static Builder|Timbra whereField24($value)
 * @method static Builder|Timbra whereField25($value)
 * @method static Builder|Timbra whereField26($value)
 * @method static Builder|Timbra whereField27($value)
 * @method static Builder|Timbra whereField28($value)
 * @method static Builder|Timbra whereField29($value)
 * @method static Builder|Timbra whereField3($value)
 * @method static Builder|Timbra whereField30($value)
 * @method static Builder|Timbra whereField31($value)
 * @method static Builder|Timbra whereField32($value)
 * @method static Builder|Timbra whereField33($value)
 * @method static Builder|Timbra whereField34($value)
 * @method static Builder|Timbra whereField35($value)
 * @method static Builder|Timbra whereField36($value)
 * @method static Builder|Timbra whereField37($value)
 * @method static Builder|Timbra whereField38($value)
 * @method static Builder|Timbra whereField39($value)
 * @method static Builder|Timbra whereField4($value)
 * @method static Builder|Timbra whereField40($value)
 * @method static Builder|Timbra whereField41($value)
 * @method static Builder|Timbra whereField42($value)
 * @method static Builder|Timbra whereField43($value)
 * @method static Builder|Timbra whereField44($value)
 * @method static Builder|Timbra whereField45($value)
 * @method static Builder|Timbra whereField46($value)
 * @method static Builder|Timbra whereField47($value)
 * @method static Builder|Timbra whereField48($value)
 * @method static Builder|Timbra whereField49($value)
 * @method static Builder|Timbra whereField5($value)
 * @method static Builder|Timbra whereField50($value)
 * @method static Builder|Timbra whereField51($value)
 * @method static Builder|Timbra whereField52($value)
 * @method static Builder|Timbra whereField53($value)
 * @method static Builder|Timbra whereField54($value)
 * @method static Builder|Timbra whereField6($value)
 * @method static Builder|Timbra whereField7($value)
 * @method static Builder|Timbra whereField8($value)
 * @method static Builder|Timbra whereField9($value)
 * @method static Builder|Timbra whereId($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class Timbra extends Model
{
    use Updater;

    protected $fillable = ['id', 'field0', 'field1', 'field2', 'field3', 'field4', 'field5', 'field6', 'field7', 'field8', 'field9', 'field10', 'field11', 'field12', 'field13', 'field14', 'field15', 'field16', 'field17', 'field18', 'field19', 'field20', 'field21', 'field22', 'field23', 'field24', 'field25', 'field26', 'field27', 'field28', 'field29', 'field30', 'field31', 'field32', 'field33', 'field34', 'field35', 'field36', 'field37', 'field38', 'field39', 'field40', 'field41', 'field42', 'field43', 'field44', 'field45', 'field46', 'field47', 'field48', 'field49', 'field50', 'field51', 'field52', 'field53', 'field54'];

    protected $connection = 'badge';

    protected $table = 'timbra';
}// end class Timbra
