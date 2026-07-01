<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Relationships;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Sigma\Models\Ana02f;
use Modules\Sigma\Models\Ana10f;
use Modules\Sigma\Models\Anag;
use Modules\Sigma\Models\Asz00f;
use Modules\Sigma\Models\Asz00k1;
use Modules\Sigma\Models\Integparam;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Qua03f;
use Modules\Sigma\Models\Rep00f;
use Modules\Sigma\Models\Sto00f;
use Modules\Sigma\Models\Wstr01lx;

trait EnteMatrRelationship
{
    public function wstr01lx(): HasMany
    {
        $enteField = $this->enteField();
        $matrField = $this->matrField();

        return $this->hasMany(Wstr01lx::class, 'wtmatr', $matrField)
            ->where('enteap', $this->{$enteField})
            ->where('wtannu', '');
    }

    public function wstr01lxYear(): HasMany
    {
        return $this->wstr01lx()
            ->whereRaw('year(wtdata) = ?', [(string) $this->anno]);
    }

    public function anag(): HasOne
    {
        return $this->hasOneByEnteMatr(Anag::class);
    }

    public function ana02f(): HasMany
    {
        return $this->hasManyByEnteMatr(Ana02f::class)
            ->whereRaw("anaann = '' ");
    }

    public function ana10f(): HasOne
    {
        return $this->hasOneByEnteMatr(Ana10f::class);
    }

    public function qua00f(): HasMany
    {
        return $this->hasManyByEnteMatr(Qua00f::class);
    }

    public function rep00f(): HasMany
    {
        return $this->hasManyByEnteMatr(Rep00f::class);
    }

    public function sto00f(): HasMany
    {
        return $this->hasManyByEnteMatr(Sto00f::class);
    }

    public function qua03f(): HasMany
    {
        return $this->hasManyByEnteMatr(Qua03f::class);
    }

    public function asz00f(): HasMany
    {
        return $this->hasManyByEnteMatr(Asz00f::class);
    }

    public function asz00k1(): HasMany
    {
        return $this->hasManyByEnteMatr(Asz00k1::class);
    }

    public function integParams(): HasMany
    {
        return $this->hasManyByEnteMatr(Integparam::class);
    }
}
