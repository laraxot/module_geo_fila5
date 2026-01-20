<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Mutators;

trait EnteStabiMutator
{
    protected function getStabiTxtAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        if (! \is_object($this->reparts)) {
            dddx($this);
        }

        $stabi = $this->reparts->where('repar', 0)->first();
        if (! \is_object($stabi)) {
            return '---';
        }

        $value = $stabi->dest1;

        if ($this->getKey() !== null) {
            $this->update(['stabi_txt' => $value]);
        }

        return $value;
    }

    protected function getReparTxtAttribute(?string $value): ?string
    {
        if ($value !== null && $value !== '---') {
            return $value;
        }

        if (! \is_object($this->reparts)) {
            dddx($this);
        }

        // reprep1 può essere una proprietà dinamica da anag o da attributi
        $repar = isset($this->repre1) && is_numeric($this->repre1) ? (int) $this->repre1 : null;
        if ($repar === null) {
            $repar = $this->repar;
        }

        $repar = $this->reparts->where('repar', $repar)->first();
        if (! \is_object($repar)) {
            return '---';
        }

        $value = $repar->dest1;
        if ($this->getKey() !== null) {
            $this->update(['repar_txt' => $value]);
        }

        return $value;
    }
}
