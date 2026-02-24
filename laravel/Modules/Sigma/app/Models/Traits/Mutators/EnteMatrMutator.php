<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Mutators;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\Sigma\Models\Codici;

/**
 * Trait EnteMatrMutator.
 *
 * @property-read int|null $emaind
 * @property-read string|null $sesso
 * @property-read string|null $codfis
 * @property-read string|null $inail
 * @property-read string|null $st2kas
 */
trait EnteMatrMutator
{
    protected function getEnteAttribute(?int $value): ?int
    {
        if ($value !== null) {
            return $value;
        }
        $value = 90;
        if (\in_array('ente', $this->getFillable(), false)) {
            $this->ente = $value;

            // Guard: modello deve avere PK per salvare ed evitare loop con Activity Log
            if ($this->getKey() != null) {
                static::withoutEvents(function () use ($value): void {
                    $this->update(['ente' => $value]);
                });
            }
        }

        return $value;
    }

    protected function getCognomeAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        $anag = $this->ana10f;
        if (! \is_object($anag)) {
            // $this->ana10f()->ddRawSql();

            return '---';
        }

        // $anag è già verificato come oggetto sopra, non può essere null
        $value = $anag->getAttribute('cognome');

        // Guard: modello deve avere PK per salvare
        if ($this->getKey() != null) {
            static::withoutEvents(function () use ($value): void {
                $this->update(['cognome' => $value]);
            });
        }

        return (string) ($value ?? '').' ';
    }

    protected function getEmailAttribute(?string $value): ?string
    {
        if ($value != null) {
            return $value;
        }
        if ($this->matr == null) {
            return null;
        }

        $ana02f = $this->ana02f()
            ->whereRaw('emaind !="" ')
            ->orderBy('datdec', 'desc')
            ->first();
        if ($ana02f === null) {
            return null;
        }

        /** @var object{emaind: string|null} $ana02f */
        $value = $ana02f->emaind;
        if (\in_array('email', $this->getFillable(), false)) {
            if ($this->getKey() != null) {
                static::withoutEvents(function () use ($value): void {
                    $this->update(['email' => $value]);
                });
            }
        }

        return $value;
    }

    protected function getSessoAttribute(?string $value): ?string
    {
        if ($value != null) {
            return Str::of($value)->lower()->toString();
        }
        if ($this->matr == null) {
            return null;
        }

        $ana02f = $this->ana02f()
            ->whereRaw('sesso !="" ')
            ->orderBy('datdec', 'desc')
            ->first();
        if ($ana02f === null) {
            return null;
        }

        /** @var object{sesso: string|null} $ana02f */
        $value = Str::of((string) $ana02f->sesso)->lower()->toString();
        if (\in_array('sesso', $this->getFillable(), false)) {
            if ($this->getKey() != null) {
                static::withoutEvents(function () use ($value): void {
                    $this->update(['sesso' => $value]);
                });
            }
        }

        return $value;
    }

    protected function getCodiceFiscaleAttribute(?string $value): ?string
    {
        if ($value != null) {
            return $value;
        }
        if ($this->matr == null) {
            return null;
        }

        $ana02f = $this->ana02f()
            ->whereRaw('codfis !="" ')
            ->orderBy('datdec', 'desc')
            ->first();
        if ($ana02f === null) {
            return null;
        }

        /** @var object{codfis: string|null} $ana02f */
        $value = $ana02f->codfis;
        if (\in_array('codfis', $this->getFillable(), false)) {
            if ($this->getKey() != null) {
                static::withoutEvents(function () use ($value): void {
                    $this->update(['codfis' => $value]);
                });
            }
        }

        return $value;
    }

    protected function getInailAttribute(?string $value): ?string
    {
        if ($value != null) {
            return $value;
        }
        if ($this->matr == null) {
            return null;
        }

        $ana02f = $this->ana02f()
            ->whereRaw('inail !="" ')
            ->orderBy('datdec', 'desc')
            ->first();
        if ($ana02f === null) {
            return null;
        }

        /** @var object{inail: string|null} $ana02f */
        $value = $ana02f->inail;
        if (\in_array('inail', $this->getFillable(), false)) {
            if ($this->getKey() != null) {
                static::withoutEvents(function () use ($value): void {
                    $this->update(['inail' => $value]);
                });
            }
        }

        return $value;
    }

    protected function getNomeAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        $anag = $this->ana10f;
        if (! ($anag instanceof \Modules\Sigma\Models\Ana10f)) {
            return '---';
        }

        $value = $anag->nome ?? null;
        if ($value === null) {
            return '---';
        }
        if (\in_array('nome', $this->getFillable(), false)) {
            $this->nome = $value;

            // Guard: modello deve avere PK per salvare
            if ($this->getKey() != null) {
                static::withoutEvents(function () use ($value): void {
                    $this->update(['nome' => $value]);
                });
            }
        }

        return $value;
    }

    protected function getTitoloDiStudioAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        $ana02f = $this->ana02f->last();
        if (! \is_object($ana02f)) {
            return null;
        }

        $row = Codici::where('tipo', 10)->where('codice', $ana02f->titstu)->first();
        if (! \is_object($row)) {
            return null;
        }

        $value = $row->desc1;
        $fieldname = 'titolo_di_studio';

        if (! Schema::connection($this->getConnectionName())->hasColumn($this->getTable(), $fieldname)) {
            Schema::connection($this->getConnectionName())->table($this->getTable(), static function (\Illuminate\Database\Schema\Blueprint $table) use (
                $fieldname,
            ): void {
                $table->string($fieldname);
            });
        }

        // $this->$fieldname=$value;
        // $this->save();
        // dddx($this->attributes);
        // dddx($this->getFillable());
        if ($this->getKey() != null) {
            static::withoutEvents(function () use ($fieldname, $value): void {
                $this->update([$fieldname => $value]);
            });
        }

        return $value;
    }

    protected function getLastDataAssunzAttribute(mixed $_value): ?string
    {
        /*
         * if (null !== $value) {
         * return $value;
         * }
         */

        $row = $this->sto00f()->orderBy('st2kas', 'desc')->first();

        if (! \is_object($row)) {
            /*
             * echo ('<h3>Aggiornare Tabella [Sto00f]
             * e controllare ente [' . $this->ente . '] matr [' . $this->matr . ']</h3>');
             * //*/
            return null;
        }

        /** @var object{st2kas: string|int|null} $row */
        $value = $row->st2kas;
        // $value = Carbon::parse($value); //meglio usare interi..
        // if ($this->attributes['last_data_assunz'] !== $value && '' !== $value) {
        if (\in_array('last_data_assunz', $this->getFillable(), false)) {
            if ($this->getKey() != null) {
                static::withoutEvents(function () use ($value): void {
                    tap($this)->update(['last_data_assunz' => $value]);
                });
            }
        } else {
            dddx('[last_data_assunz] not in fillable in class ['.static::class.']');
        }

        return $value === null ? null : (string) $value;
    }
}
