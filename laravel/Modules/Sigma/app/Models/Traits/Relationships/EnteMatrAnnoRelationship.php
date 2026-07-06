<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Relationships;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Sigma\Models\Asz00k1;
use Modules\Sigma\Models\Contracts\EnteMatrFieldsContract;
use Modules\Sigma\Models\Qua00f;
use Modules\Sigma\Models\Sto00f;

/**
 * @phpstan-require-implements EnteMatrFieldsContract
 *
 * @property int|null $anno
 */
trait EnteMatrAnnoRelationship
{
    /**
     * @return HasMany<Qua00f, static>
     */
    public function qua00fYear(): HasMany
    {
        /** @var string $sql */
        $sql = '(
		('.$this->anno.' between year(qua2kd) and year(qua2ka) )or
		('.$this->anno.' >= year(qua2kd) and qua2ka=0)
		)';

        /** @var int $inizioanno */
        $inizioanno = ($this->anno * 10000) + 101;
        /** @var int $fineanno */
        $fineanno = ($this->anno * 10000) + 1231;

        // @phpstan-ignore-next-line - Template type TDeclaringModel on HasMany is not covariant
        /** @var HasMany<Qua00f, static> $relation */
        $relation = $this->hasMany(Qua00f::class, 'matr', $this->matrField());

        return $relation
            ->selectRaw('ente,matr,propro,posfun,posiz
				,if(oree=0,36,oree) as oree
				,if(oret=0,36,oret) as oret
				,if(qua2kd<'
            .$inizioanno
            .','
            .$inizioanno
            .',qua2kd) as qua2kd
				,if(qua2ka=0,'
            .$fineanno
            .',qua2ka) as qua2ka
				,datediff(if(qua2ka=0,'
            .$fineanno
            .',qua2ka),if(qua2kd<'
            .$inizioanno
            .','
            .$inizioanno
            .',qua2kd))+1 as giorni
				')
            ->whereRaw('quaann=""')
            ->where('ente', $this->{$this->enteField()})
            ->whereRaw($sql);
    }

    /**
     * @return HasMany<Sto00f, static>
     */
    public function Sto00fYear(): HasMany
    {
        /** @var string $sql */
        $sql = '(
		('.$this->anno.' between year(st2kas) and year(st2kdi) )or
		('.$this->anno.' >= year(st2kas) and st2kdi=0)
	)';
        /** @var int $inizioanno */
        $inizioanno = ($this->anno * 10000) + 101;
        /** @var int $fineanno */
        $fineanno = ($this->anno * 10000) + 1231;

        // @phpstan-ignore-next-line - Template type TDeclaringModel on HasMany is not covariant
        return $this->hasMany(Sto00f::class, 'matr', $this->matrField())
            ->selectRaw('ente,matr
				,if(st2kas<'
            .$inizioanno
            .','
            .$inizioanno
            .',st2kas) as dal
				,if(st2kdi=0,'
            .$fineanno
            .',st2kdi) as al
				,datediff(if(st2kdi=0,'
            .$fineanno
            .',st2kdi),if(st2kas<'
            .$inizioanno
            .','
            .$inizioanno
            .',st2kas))+1 as giorni
				')
            ->whereRaw('stann=""')
            ->where('ente', $this->{$this->enteField()})
            ->whereRaw($sql);
    }

    /**
     * @return HasMany<Asz00k1, $this>
     */
    public function asz00k1Year(): HasMany
    {
        // Asz00k1::indexIfNotExistsStatic(['ente','matr','aszann','asz2kd','asz2ka']);
        // @phpstan-ignore-next-line - Template type TDeclaringModel on HasMany is not covariant
        return $this->hasMany(Asz00k1::class, 'matr', $this->matrField())
            ->where('ente', $this->{$this->enteField()})
            ->whereRaw('aszann=""')
            ->whereRaw((string) $this->anno.' between year(asz2kd) and year(asz2ka) ');
    }
}
