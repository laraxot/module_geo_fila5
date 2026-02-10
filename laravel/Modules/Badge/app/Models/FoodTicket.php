<?php

declare(strict_types=1);

namespace Modules\Badge\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Badge\Database\Factories\FoodTicketFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Badge\Models\FoodTicket.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $cognome
 * @property string|null $nome
 * @property int|null $propro
 * @property int|null $posfun
 * @property string $categoria_eco
 * @property int|null $posiz
 * @property int $posiz_txt
 * @property int|null $stabi
 * @property string|null $stabi_txt
 * @property int|null $repar
 * @property string|null $repar_txt
 * @property int|null $is_regionale
 * @property int|null $n_diritto
 * @property int|null $n_mensa
 * @property int|null $n_dati
 * @property int|null $n_dati_tot
 * @property int|null $n_resi
 * @property int|null $n_resi_tot
 * @property string|null $giorno
 * @property int|null $mese
 * @property int|null $anno
 * @property string|null $note
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property Carbon|null $updated_at
 * @property string|null $updated_wstr02f_at
 * @property string|null $updated_wmen00f_at
 * @property string|null $updated_wstr01lx_at
 * @property string|null $updated_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property int $disci1
 *
 * @method static FoodTicketFactory factory($count = null, $state = [])
 * @method static Builder|FoodTicket newModelQuery()
 * @method static Builder|FoodTicket newQuery()
 * @method static Builder|FoodTicket query()
 * @method static Builder|FoodTicket whereAnno($value)
 * @method static Builder|FoodTicket whereCategoriaEco($value)
 * @method static Builder|FoodTicket whereCognome($value)
 * @method static Builder|FoodTicket whereCreatedAt($value)
 * @method static Builder|FoodTicket whereCreatedBy($value)
 * @method static Builder|FoodTicket whereDeletedAt($value)
 * @method static Builder|FoodTicket whereDeletedBy($value)
 * @method static Builder|FoodTicket whereDisci1($value)
 * @method static Builder|FoodTicket whereEnte($value)
 * @method static Builder|FoodTicket whereGiorno($value)
 * @method static Builder|FoodTicket whereId($value)
 * @method static Builder|FoodTicket whereIsRegionale($value)
 * @method static Builder|FoodTicket whereMatr($value)
 * @method static Builder|FoodTicket whereMese($value)
 * @method static Builder|FoodTicket whereNDati($value)
 * @method static Builder|FoodTicket whereNDatiTot($value)
 * @method static Builder|FoodTicket whereNDiritto($value)
 * @method static Builder|FoodTicket whereNMensa($value)
 * @method static Builder|FoodTicket whereNResi($value)
 * @method static Builder|FoodTicket whereNResiTot($value)
 * @method static Builder|FoodTicket whereNome($value)
 * @method static Builder|FoodTicket whereNote($value)
 * @method static Builder|FoodTicket wherePosfun($value)
 * @method static Builder|FoodTicket wherePosiz($value)
 * @method static Builder|FoodTicket wherePosizTxt($value)
 * @method static Builder|FoodTicket wherePropro($value)
 * @method static Builder|FoodTicket whereRepar($value)
 * @method static Builder|FoodTicket whereReparTxt($value)
 * @method static Builder|FoodTicket whereStabi($value)
 * @method static Builder|FoodTicket whereStabiTxt($value)
 * @method static Builder|FoodTicket whereUpdatedAt($value)
 * @method static Builder|FoodTicket whereUpdatedBy($value)
 * @method static Builder|FoodTicket whereUpdatedWmen00fAt($value)
 * @method static Builder|FoodTicket whereUpdatedWstr01lxAt($value)
 * @method static Builder|FoodTicket whereUpdatedWstr02fAt($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class FoodTicket extends BaseModel
{
    protected $fillable = ['id', 'ente', 'matr', 'cognome', 'nome', 'propro', 'posfun', 'categoria_eco', 'posiz', 'posiz_txt', 'stabi', 'stabi_txt', 'repar', 'repar_txt', 'is_regionale', 'n_diritto', 'n_mensa', 'n_dati', 'n_dati_tot', 'n_resi', 'n_resi_tot', 'giorno', 'mese', 'anno', 'note', 'created_at', 'created_by', 'updated_at', 'updated_wstr02f_at', 'updated_wmen00f_at', 'updated_wstr01lx_at', 'updated_by', 'deleted_at', 'deleted_by', 'disci1'];
}
