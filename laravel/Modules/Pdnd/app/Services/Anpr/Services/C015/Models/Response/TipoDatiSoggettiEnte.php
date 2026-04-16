<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Services\C015\Models\Response;

use Modules\Pdnd\Services\Anpr\Services\C015\Models\Common\TipoGeneralita;

class TipoDatiSoggettiEnte
{
    public function __construct(
        public readonly ?TipoGeneralita $generalita = null,
        public readonly ?TipoStatoCivile $statoCivile = null,
        public readonly ?TipoIdentificativi $identificativi = null,
        public readonly ?array $infoSoggettoEnte = null  // array<TipoInfoSoggettoEnte>
    ) {}

    public function toArray(): array
    {
        $data = [];

        if ($this->infoSoggettoEnte !== null) {
            $data['infoSoggettoEnte'] = array_map(
                static fn (TipoInfoSoggettoEnte $info) => $info->toArray(),
                $this->infoSoggettoEnte
            );
        }

        return $data;
    }

public static function fromArray(array $data): self
    {
        return new self(
            generalita: isset($data['generalita']) ? TipoGeneralita::fromArray($data['generalita']) : null,
            statoCivile: isset($data['statoCivile']) ? TipoStatoCivile::fromArray($data['statoCivile']) : null,
            identificativi: isset($data['identificativi']) ? TipoIdentificativi::fromArray($data['identificativi']) : null,
            infoSoggettoEnte: isset($data['infoSoggettoEnte']) 
                ? array_map([TipoInfoSoggettoEnte::class, 'fromArray'], $data['infoSoggettoEnte']) 
                : null
        );
    }

    /**
     * Verifica se ha informazioni
     */
    public function hasInfo(): bool
    {
        return $this->infoSoggettoEnte !== null && ! empty($this->infoSoggettoEnte);
    }

    /**
     * Conta le informazioni
     */
    public function countInfo(): int
    {
        return count($this->infoSoggettoEnte ?? []);
    }

    /**
     * Ottieni un'informazione specifica per chiave
     */
    public function getInfoPerChiave(string $chiave): ?TipoInfoSoggettoEnte
    {
        if (! $this->hasInfo() || $this->infoSoggettoEnte === null) {
            return null;
        }

        foreach ($this->infoSoggettoEnte as $info) {
            if ($info->chiave === $chiave) {
                return $info;
            }
        }

        return null;
    }

    /**
     * Ottieni tutte le informazioni come oggetti
     *
     * @return array<int, TipoInfoSoggettoEnte>
     */
    public function getAllInfo(): array
    {
        if (! $this->hasInfo() || $this->infoSoggettoEnte === null) {
            return [];
        }

        return $this->infoSoggettoEnte;
    }

    /**
     * Ottieni il valore di un'informazione per chiave
     */
    public function getValorePerChiave(string $chiave): mixed
    {
        $info = $this->getInfoPerChiave($chiave);

        if ($info === null) {
            return null;
        }

        // Restituisce il valore più appropriato
        if ($info->valore !== null) {
            return $info->valore;
        }

        if ($info->valoreTesto !== null) {
            return $info->valoreTesto;
        }

        if ($info->valoreData !== null) {
            return $info->valoreData;
        }

        return null;
    }
}
