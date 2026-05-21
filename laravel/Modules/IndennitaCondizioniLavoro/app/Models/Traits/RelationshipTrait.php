<?php

declare(strict_types=1);

namespace Modules\IndennitaCondizioniLavoro\Models\Traits;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Modules\IndennitaCondizioniLavoro\Models\IndennitaTipoDettaglio;
use Modules\IndennitaCondizioniLavoro\Models\StabiDirigente;
use Modules\Sigma\Models\Traits\Relationships\EnteMatrAnnoRelationship;
use Modules\Sigma\Models\Traits\Relationships\EnteMatrDateRangeRelationship;
use Modules\Sigma\Models\Traits\Relationships\EnteMatrRelationship;

// use Laravel\Scout\Searchable;
// ----- models------
// use Modules\IndennitaCondizioniLavoro\Models\IndennitaResponsabilita;
// ------ ext models---

// ----- services -----

// ------ traits ---

trait RelationshipTrait
{
    use EnteMatrAnnoRelationship;
    use EnteMatrDateRangeRelationship;
    use EnteMatrRelationship;

    /*
    public function anag(): HasOne {
        return $this->hasOne(Anag::class, 'matr', 'matr')->where('ente', $this->ente);
    }
    */
    /* --- deprecate
    public function trasferte(): HasMany {
        config(['trasferte_conn' => 'trasferte_dip']);

        return $this->hasMany(FuoriSedeDip::class, 'matr', 'matr')
            ->where('ente', $this->ente)
            ->where('last_stato', '!=', 66)
            ->whereRaw('year(data_start)="'.$this->anno.'"')
            ->with(['motivo', 'approvaz', 'giust'])
                ;
    }
    */
    /*
    public function qua00f(): HasMany {
        return $this->hasMany(Qua00f::class, 'matr', 'matr')
            ->where('ente', '90') //$this->ente non ce la fa
            ->whereRaw('quaann=""');
        //->ofRangeDate($this->dal,$this->al)
    }
    */
    public function getIndennitaTipoDettaglioAllAttribute(): Collection
    {
        /** @phpstan-ignore argument.type */
        return IndennitaTipoDettaglio::whereRaw($this->anno.' between dal and al')->get();
    }

    public function stabiDirigente(): HasOne
    {
        return $this->hasOne(StabiDirigente::class, 'stabi', 'stabi')->where('repar', $this->repar);
    }

    /*
    public function asz00k1(): HasMany {
        $sql = $this->anno.' between year(asz2kd) and year(asz2ka)';

        return $this->hasMany(Asz00k1::class, 'matr', 'matr')
            ->where('ente', $this->ente)
            ->whereRaw('aszann=""')
            ->whereRaw($sql);
    }
    */

    /*
    public function qua00f(): void {
        $sql='(
            ('.$this->anno.' between year(qua2kd) and year(qua2ka)) or
            ('.$this->anno.' >= year(qua2kd) and qua2ka=0)
        )';
        return $this->hasMany(Qua00f::class,'matr','matr')
            ->where('ente',$this->ente)
            ->whereRaw('quaann=""')
            ->whereRaw($sql);
    }
    */

    /*
    public function wstr01lx(): HasMany {
        return $this->hasMany(Wstr01lx::class, 'wtmatr', 'matr')
            ->where('enteap', $this->ente)
            ->whereRaw('wtannu=""')
            ->whereRaw('year(wtdata)="'.$this->anno.'"')
                ;
    }
    */
}
