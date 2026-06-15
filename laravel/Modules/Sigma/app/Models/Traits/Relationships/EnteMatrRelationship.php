<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Relationships;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

/**
 * Trait EnteMatrRelationship.
 *
 * @property int|null $anno
 * @property int|null $ente
 * @property string|null $matr
 */
trait EnteMatrRelationship
{
    /**
     * @return HasMany<Wstr01lx, $this>
     *
     * @phpstan-ignore-next-line return.type - Template type TDeclaringModel not covariant
     */
    public function wstr01lx(): HasMany
    {
        return $this->hasMany(Wstr01lx::class, 'wtmatr', 'matr')->where('enteap', $this->ente)->where('wtannu', '');
    }

    /**
     * @return HasMany<Wstr01lx, $this>
     */
    public function wstr01lxYear(): HasMany
    {
        return $this->wstr01lx()->whereRaw('year(wtdata) = ?', [(string) $this->anno]);
    }

    /**
     * Shared anagrafica relationship.
     *
     * Child models (with FK) override to BelongsTo, parent models keep HasOne.
     */
    public function anag(): HasOne|BelongsTo
    {
        return $this->hasOne(Anag::class, 'matr', 'matr')->where('ente', $this->ente);
    }

    /**
     * @return HasMany<Ana02f, $this>
     */
    public function ana02f(): HasMany
    {
        return $this->hasMany(Ana02f::class, 'matr', 'matr')->where('ente', $this->ente)->whereRaw("anaann = '' ");
    }

    public function ana10f(): HasOne
    {
        return $this->hasOne(Ana10f::class, 'matr', 'matr')->where('ente', $this->ente);
    }

    /**
     * @return HasMany<Qua00f, $this>
     */
    public function qua00f(): HasMany
    {
        return $this->hasMany(Qua00f::class, 'matr', 'matr')->where('ente', $this->ente)->whereRaw('quaann=""');
    }

    /**
     * @return HasMany<Rep00f, $this>
     */
    public function rep00f(): HasMany
    {
        return $this->hasMany(Rep00f::class, 'matr', 'matr')->where('ente', $this->ente)->whereRaw("repann = '' ");

        // ->whereNotNull('repann')
    }

    /**
     * @return HasMany<Sto00f, $this>
     */
    public function sto00f(): HasMany
    {
        return $this->hasMany(Sto00f::class, 'matr', 'matr')->where('ente', $this->ente)->whereRaw("stann = '' ");
    }

    /**
     * @return HasMany<Qua03f, $this>
     */
    public function qua03f(): HasMany
    {
        return $this->hasMany(Qua03f::class, 'matr', 'matr')->where('ente', $this->ente)->where('q3ann', '');
    }

    /**
     * @return HasMany<Asz00f, $this>
     */
    public function asz00f(): HasMany
    {
        return $this->hasMany(Asz00f::class, 'matr', 'matr')->where('ente', $this->ente)->where('aszann', '');
    }

    /**
     * @return HasMany<Asz00k1, $this>
     */
    public function asz00k1(): HasMany
    {
        $table = (new Asz00k1)->getTable();

        return $this->hasMany(Asz00k1::class, 'matr', 'matr')
            ->where($table.'.ente', $this->ente)
            ->where($table.'.aszann', '');
    }

    /**
     * @return HasMany<Integparam, $this>
     */
    public function integParams(): HasMany
    {
        return $this->hasMany(Integparam::class, 'matr', 'matr')->where('ente', $this->ente);
    }
}
