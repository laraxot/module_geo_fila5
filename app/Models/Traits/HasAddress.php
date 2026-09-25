<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Geo\Enums\AddressItemEnum;
use Modules\Geo\Models\Address;
<<<<<<< HEAD
use Webmozart\Assert\Assert;

use function Safe\preg_replace;

=======

use function Safe\preg_replace;

use Webmozart\Assert\Assert;

>>>>>>> laraxot/dev
/**
 * Trait HasAddress.
 *
 * Fornisce funzionalità per la gestione degli indirizzi nei modelli Eloquent.
 * Questo trait implementa la relazione polimorfica con il modello Address
 * e offre metodi di utilità per la gestione degli indirizzi.
 *
 * @property Collection<int, Address> $addresses
<<<<<<< HEAD
 * @property string|null $route
 * @property string|null $street_number
 * @property string|null $postal_code
 * @property string|null $city
 * @property string|null $province
 * @property string|int $id
=======
 * @property string|null              $route
 * @property string|null              $street_number
 * @property string|null              $postal_code
 * @property string|null              $city
 * @property string|null              $province
 * @property string|int               $id
>>>>>>> laraxot/dev
 *
 * @phpstan-require-extends Model
 */
trait HasAddress
{
    /**
     * Ottiene gli indirizzi associati al modello.
     *
     * @return MorphMany<Address, $this>
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'model');
    }

    /**
     * Ottiene indirizzo associato al modello.
     *
     * @return MorphOne<Address, $this>
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'model');
    }

    /**
     * Ottiene l'indirizzo principale del modello.
     */
    public function primaryAddress(): ?Address
    {
        $res = $this->addresses()->where('is_primary', true)->first();
<<<<<<< HEAD
        if ($res === null) {
=======
        if (null === $res) {
>>>>>>> laraxot/dev
            return $res;
        }
        Assert::isInstanceOf($res, Address::class);

        return $res;
    }

    /**
     * Ottiene l'indirizzo completo formattato.
     */
    public function getFullAddress(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->getFullAddress() : null;
    }

    public function getFullAddressAttribute(?string $value): string
    {
<<<<<<< HEAD
        if ($value !== null) {
=======
        if (null !== $value) {
>>>>>>> laraxot/dev
            return $value;
        }
        $address = sprintf(
            '%s, %s - %s, %s (%s)',
            $this->route,
            $this->street_number,
            $this->postal_code,
            $this->city,
            $this->province,
        );

        return trim(preg_replace('/[,\s]+/', ' ', $address));
    }

    public function getFullAddressesAttribute(?string $value): ?string
    {
        if ($value) {
            return $value;
        }
        $address = $this->address()->first();
<<<<<<< HEAD
        if ($address === null) {
=======
        if (null === $address) {
>>>>>>> laraxot/dev
            return null;
        }
        Assert::isInstanceOf($address, Address::class);

        $locality = $address->getLocality();
<<<<<<< HEAD
        if ($locality === null) {
=======
        if (null === $locality) {
>>>>>>> laraxot/dev
            return null;
        }

        $streetAddress = is_string($address->street_address) ? $address->street_address : '';
        $streetNumber = is_string($address->street_number) ? $address->street_number : '';
        $postalCode = is_string($address->postal_code) ? $address->postal_code : '';

        $localityNome = isset($locality['nome']) && is_string($locality['nome']) ? $locality['nome'] : '';
        $provinciaNome = isset($locality['provincia']) && is_array($locality['provincia']) && isset($locality['provincia']['nome']) && is_string($locality['provincia']['nome']) ? $locality['provincia']['nome'] : '';

        return $streetAddress.
            ', '.
            $streetNumber.
            ' - '.
            $postalCode.
            ' '.
            $localityNome.
            ' ('.
            $provinciaNome.
            ') ';
    }

    /**
     * Ottiene la località dell'indirizzo principale.
     */
    public function getCity(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->locality : null;
    }

    /**
     * Ottiene il CAP dell'indirizzo principale.
     */
    public function getPostalCode(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->postal_code : null;
    }

    /**
     * Ottiene la provincia dell'indirizzo principale.
     */
    public function getProvince(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->administrative_area_level_3 : null;
    }

    /**
     * Ottiene la regione dell'indirizzo principale.
     */
    public function getRegion(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->administrative_area_level_2 : null;
    }

    /**
     * Ottiene il paese dell'indirizzo principale.
     */
    public function getCountry(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->country : null;
    }

    /**
     * Imposta un indirizzo come principale e rimuove il flag da tutti gli altri.
     */
    public function setAsPrimaryAddress(Address $address): bool
    {
        // Verifica che l'indirizzo appartenga a questo modello
        if ($address->model_id !== $this->id || $address->model_type !== static::class) {
            return false;
        }

        // Rimuovi il flag is_primary da tutti gli altri indirizzi
        $this->addresses()
            ->where('id', '!=', $address->id)
            ->where('is_primary', true)
            ->update(['is_primary' => false]);

        // Imposta questo indirizzo come principale
        return $address->update(['is_primary' => true]);
    }

    /**
     * Ottiene gli indirizzi di un determinato tipo.
     *
     * @return Collection<int, Address>
     *
     * @phpstan-return Collection<int, Address>
     */
    public function getAddressesByType(string $type): Collection
    {
        return $this->addresses()->where('type', $type)->get();
    }

    /**
     * Aggiunge un nuovo indirizzo al modello.
     *
<<<<<<< HEAD
     * @param  array<string, mixed>  $data
     * @param  bool  $setPrimary  Se impostare questo indirizzo come principale
=======
     * @param array<string, mixed> $data
     * @param bool                 $setPrimary Se impostare questo indirizzo come principale
>>>>>>> laraxot/dev
     *
     * @phpstan-param array<string, mixed> $data
     */
    public function addAddress(array $data, bool $setPrimary = false): Address
    {
<<<<<<< HEAD
        if ($setPrimary || $this->addresses()->count() === 0) {
=======
        if ($setPrimary || 0 === $this->addresses()->count()) {
>>>>>>> laraxot/dev
            $data['is_primary'] = true;

            if ($this->addresses()->count() > 0) {
                $this->addresses()->update(['is_primary' => false]);
            }
        }

        return $this->addresses()->create($data);
    }

    /**
     * Aggiorna l'indirizzo principale.
     *
<<<<<<< HEAD
     * @param  array<string, mixed>  $data
=======
     * @param array<string, mixed> $data
>>>>>>> laraxot/dev
     *
     * @phpstan-param array<string, mixed> $data
     */
    public function updatePrimaryAddress(array $data): ?Address
    {
        $primaryAddress = $this->primaryAddress();
        if (! $primaryAddress) {
            return $this->addAddress($data, true);
        }

        $primaryAddress->update($data);

        return $primaryAddress;
    }

    /**
     * Scope: modelli con almeno un indirizzo nella città indicata (`locality`).
     *
<<<<<<< HEAD
     * @param  Builder<static>  $query
=======
     * @param Builder<static> $query
>>>>>>> laraxot/dev
     *
     * @phpstan-param Builder<static> $query
     *
     * @return Builder<static>
     *
     * @phpstan-return Builder<static>
     */
    public function scopeInCity(Builder $query, string $city): Builder
    {
        return $query->whereHas(
            'addresses',
            /**
<<<<<<< HEAD
             * @param  Builder<Address>  $q
=======
             * @param Builder<Address> $q
>>>>>>> laraxot/dev
             */
            function (Builder $q) use ($city): void {
                $q->where('locality', $city);
            },
        );
    }

    /**
     * Scope: modelli con almeno un indirizzo nella provincia (`administrative_area_level_3`).
     *
<<<<<<< HEAD
     * @param  Builder<static>  $query
=======
     * @param Builder<static> $query
>>>>>>> laraxot/dev
     *
     * @phpstan-param Builder<static> $query
     *
     * @return Builder<static>
     *
     * @phpstan-return Builder<static>
     */
    public function scopeInProvince(Builder $query, string $province): Builder
    {
        return $query->whereHas(
            'addresses',
            /**
<<<<<<< HEAD
             * @param  Builder<Address>  $q
=======
             * @param Builder<Address> $q
>>>>>>> laraxot/dev
             */
            function (Builder $q) use ($province): void {
                $q->where('administrative_area_level_3', $province);
            },
        );
    }

    /**
     * Scope: modelli con almeno un indirizzo nella regione (`administrative_area_level_2`).
     *
<<<<<<< HEAD
     * @param  Builder<static>  $query
=======
     * @param Builder<static> $query
>>>>>>> laraxot/dev
     *
     * @phpstan-param Builder<static> $query
     *
     * @return Builder<static>
     *
     * @phpstan-return Builder<static>
     */
    public function scopeInRegion(Builder $query, string $region): Builder
    {
        return $query->whereHas(
            'addresses',
            /**
<<<<<<< HEAD
             * @param  Builder<Address>  $q
=======
             * @param Builder<Address> $q
>>>>>>> laraxot/dev
             */
            function (Builder $q) use ($region): void {
                $q->where('administrative_area_level_2', $region);
            },
        );
    }

    /**
     * Scope: modelli con almeno un indirizzo con il CAP indicato.
     *
<<<<<<< HEAD
     * @param  Builder<static>  $query
=======
     * @param Builder<static> $query
>>>>>>> laraxot/dev
     *
     * @phpstan-param Builder<static> $query
     *
     * @return Builder<static>
     *
     * @phpstan-return Builder<static>
     */
    public function scopeInPostalCode(Builder $query, string $postalCode): Builder
    {
        return $query->whereHas(
            'addresses',
            /**
<<<<<<< HEAD
             * @param  Builder<Address>  $q
=======
             * @param Builder<Address> $q
>>>>>>> laraxot/dev
             */
            function (Builder $q) use ($postalCode): void {
                $q->where('postal_code', $postalCode);
            },
        );
    }

    /**
     * Initialize the trait.
     */
    protected function initializeHasAddress(): void
    {
        /** @var array<string> $fields */
        $fields = array_values(array_map(
            fn (AddressItemEnum $item): string => $item->value,
            AddressItemEnum::cases(),
        ));
        $this->mergeFillable($fields);
    }
}
